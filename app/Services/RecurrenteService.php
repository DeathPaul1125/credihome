<?php

namespace App\Services;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecurrenteService
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;
    protected $isTestMode;

    public function __construct()
    {
        $config = Configuracion::obtener();

        $this->isTestMode = $config->recurrente_modo_prueba ?? true;

        if ($this->isTestMode) {
            $this->publicKey = $config->recurrente_public_key_test;
            $this->secretKey = $config->recurrente_secret_key_test;
        } else {
            $this->publicKey = $config->recurrente_public_key;
            $this->secretKey = $config->recurrente_secret_key;
        }

        $this->baseUrl = 'https://app.recurrente.com/api';
    }

    /**
     * Verificar si Recurrente está habilitado y configurado
     */
    public function isEnabled(): bool
    {
        $config = Configuracion::obtener();

        if (!$config->recurrente_habilitado) {
            return false;
        }

        // Verificar que las llaves estén configuradas
        if ($this->isTestMode) {
            return !empty($this->publicKey) && !empty($this->secretKey);
        }

        return !empty($this->publicKey) && !empty($this->secretKey);
    }

    /**
     * Obtener headers de autenticación
     */
    protected function getHeaders(): array
    {
        return [
            'X-PUBLIC-KEY' => $this->publicKey,
            'X-SECRET-KEY' => $this->secretKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Crear un checkout/sesión de pago
     *
     * @param array $data Datos del checkout
     * @return array|null
     */
    public function createCheckout(array $data): ?array
    {
        try {
            if (!$this->isEnabled()) {
                throw new \Exception('Recurrente no está habilitado o configurado correctamente');
            }

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/checkouts", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al crear checkout en Recurrente', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al crear checkout en Recurrente: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener información de un checkout
     *
     * @param string $checkoutId
     * @return array|null
     */
    public function getCheckout(string $checkoutId): ?array
    {
        try {
            if (!$this->isEnabled()) {
                throw new \Exception('Recurrente no está habilitado');
            }

            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/checkouts/{$checkoutId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener checkout: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crear un cliente en Recurrente
     *
     * @param array $data
     * @return array|null
     */
    public function createCustomer(array $data): ?array
    {
        try {
            if (!$this->isEnabled()) {
                throw new \Exception('Recurrente no está habilitado');
            }

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/customers", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al crear cliente en Recurrente', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al crear cliente en Recurrente: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crear un reembolso
     *
     * @param string $chargeId
     * @param float|null $amount Monto a reembolsar (null = total)
     * @return array|null
     */
    public function createRefund(string $chargeId, ?float $amount = null): ?array
    {
        try {
            if (!$this->isEnabled()) {
                throw new \Exception('Recurrente no está habilitado');
            }

            $data = ['charge_id' => $chargeId];

            if ($amount !== null) {
                $data['amount'] = $amount;
            }

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/refunds", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al crear reembolso en Recurrente', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al crear reembolso en Recurrente: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verificar autenticación
     *
     * @return bool
     */
    public function testAuthentication(): bool
    {
        try {
            if (!$this->publicKey || !$this->secretKey) {
                return false;
            }

            // Intentar listar customers para probar autenticación
            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/customers", ['limit' => 1]);

            return $response->successful() && $response->status() !== 401;
        } catch (\Exception $e) {
            Log::error('Error al probar autenticación de Recurrente: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener el modo actual
     *
     * @return string 'test' o 'live'
     */
    public function getMode(): string
    {
        return $this->isTestMode ? 'test' : 'live';
    }
}
