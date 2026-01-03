<?php

namespace TestProject\CasinoCards\Api\Adapter;

use Exception;
use TestProject\CasinoCards\Api\Dto\Casino;
use TestProject\CasinoCards\Api\Dto\CasinoListItem;
use TestProject\CasinoCards\Foundation\Interfaces\CasinoApiInterface;
use TestProject\CasinoCards\Foundation\Interfaces\CasinoProviderInterface;

/**
 * CartableCasinoAdapter class
 */
class CartableCasinoAdapter implements CasinoProviderInterface
{
    /**
     * @var CasinoApiInterface
     */
    private CasinoApiInterface $api;

    /**
     * @param CasinoApiInterface $api
     */
    public function __construct(CasinoApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @throws Exception
     */
    public function getCasino(string $id): Casino
    {
        $data = $this->api->getCasinoResponse($id);
        if (! isset($data['id'], $data['name'])) {
            throw new Exception('Invalid API response: required fields missing (id, name)');
        }

        return new Casino(
            id: (string) $data['id'],
            name: (string) $data['name'],
            logoUrl: (string) ($data['logo_url'] ?? ''),
            averageRtp: (float) ($data['average_rtp'] ?? 0),
            biggestWinMonth: (float) ($data['biggest_win_month'] ?? 0),
            paymentDelayHours: (int) ($data['payment_delay_hours'] ?? 0),
            monthlyWithdrawalLimit: (float) ($data['monthly_withdrawal_limit'] ?? 0),
            validatedWithdrawalsValue: (float) ($data['validated_withdrawals_value'] ?? 0),
            monthlyWithdrawalsNumber: (int) ($data['monthly_withdrawals_number'] ?? 0),
            cta: (string) ($data['cta'] ?? ''),
            bonusTitle: $data['bonus_title'] ?? null,
            bonusDescription: $data['bonus_description'] ?? null,
        );
    }

    /**
     * @return array|CasinoListItem[]
     */
    public function getCasinoList(): array
    {
        $data = $this->api->getCasinoListResponse();
        $result = [];
        foreach ($data as $item) {
            if (! is_array($item) || ! isset($item['id'], $item['name'])) {
                // TODO: Implement Monolog
                error_log('[CartableCasinoAdapter] Invalid list item skipped');
                continue;
            }

            $result[] = new CasinoListItem(
                id: (string) $item['id'],
                name: (string) $item['name']
            );
        }

        return $result;
    }
}
