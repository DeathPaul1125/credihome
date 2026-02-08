<?php

if (!function_exists('money')) {
    /**
     * Formatear número como moneda con coma para millares y punto para decimales
     *
     * @param float|int|string $amount
     * @param int $decimals
     * @param bool $includeSymbol
     * @param string $symbol
     * @return string
     */
    function money($amount, $decimals = 2, $includeSymbol = false, $symbol = 'Q')
    {
        if ($amount === null || $amount === '') {
            $amount = 0;
        }

        $formatted = number_format((float)$amount, $decimals, '.', ',');

        return $includeSymbol ? $symbol . ' ' . $formatted : $formatted;
    }
}

if (!function_exists('money_symbol')) {
    /**
     * Formatear número como moneda con símbolo incluido
     *
     * @param float|int|string $amount
     * @param int $decimals
     * @param string $symbol
     * @return string
     */
    function money_symbol($amount, $decimals = 2, $symbol = 'Q')
    {
        return money($amount, $decimals, true, $symbol);
    }
}

if (!function_exists('percentage')) {
    /**
     * Formatear número como porcentaje
     *
     * @param float|int|string $value
     * @param int $decimals
     * @return string
     */
    function percentage($value, $decimals = 2)
    {
        if ($value === null || $value === '') {
            $value = 0;
        }

        return number_format((float)$value, $decimals, '.', ',') . '%';
    }
}

if (!function_exists('recurrente')) {
    /**
     * Obtener instancia del servicio de Recurrente
     *
     * @return \App\Services\RecurrenteService
     */
    function recurrente()
    {
        return new \App\Services\RecurrenteService();
    }
}
