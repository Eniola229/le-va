<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.brevo.com/v3/smtp/email';
    private array  $defaultSender;

    public function __construct()
    {
        $this->apiKey = config('services.brevo.api_key');
        $this->defaultSender = [
            'name'  => config('mail.from.name', 'Lev Av'),
            'email' => config('mail.from.address', 'hello@levav.com'),
        ];
    }

    /**
     * Send a transactional email via Brevo API.
     *
     * @param  string|array  $to        'email' or ['email'=>..., 'name'=>...]  or array of those
     * @param  string        $subject
     * @param  string        $htmlContent
     * @param  string|null   $textContent
     */
    public function send(
        string|array $to,
        string $subject,
        string $htmlContent,
        ?string $textContent = null
    ): bool {
        // Normalise $to to array of {email, name?} objects
        $recipients = $this->normaliseRecipients($to);

        $payload = [
            'sender'      => $this->defaultSender,
            'to'          => $recipients,
            'subject'     => $subject,
            'htmlContent' => $htmlContent,
        ];

        if ($textContent) {
            $payload['textContent'] = $textContent;
        }

        try {
            $ch = curl_init($this->baseUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => json_encode($payload),
                CURLOPT_HTTPHEADER     => [
                    'accept: application/json',
                    'api-key: ' . $this->apiKey,
                    'content-type: application/json',
                ],
            ]);

            $response = curl_exec($ch);
            $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status >= 200 && $status < 300) {
                return true;
            }

            Log::error('Brevo API error', [
                'status'   => $status,
                'response' => $response,
                'to'       => $recipients,
                'subject'  => $subject,
            ]);

            return false;

        } catch (\Throwable $e) {
            Log::error('Brevo send exception: ' . $e->getMessage());
            return false;
        }
    }

    // ── Batch send (for announcements) ──────────────────────
    /**
     * Send the same email to many recipients in chunks.
     * Brevo allows up to 50 recipients per call.
     */
    public function sendBatch(
        array $recipients,
        string $subject,
        string $htmlContent,
        ?string $textContent = null
    ): void {
        foreach (array_chunk($recipients, 50) as $chunk) {
            $this->send($chunk, $subject, $htmlContent, $textContent);
        }
    }

    // ── Helpers ─────────────────────────────────────────────
    private function normaliseRecipients(string|array $to): array
    {
        if (is_string($to)) {
            return [['email' => $to]];
        }

        // Single assoc array: ['email'=>..., 'name'=>...]
        if (isset($to['email'])) {
            return [$to];
        }

        // Already an indexed array of recipients
        return array_map(function ($item) {
            return is_string($item) ? ['email' => $item] : $item;
        }, $to);
    }
}


