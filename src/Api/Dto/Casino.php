<?php

namespace TestProject\CasinoCards\Api\Dto;

/**
 * Casino class
 */
class Casino
{
    public string $id;
    public string $name;
    public string $logoUrl = '';

    public float $averageRtp;
    public float $biggestWinMonth;
    public int $paymentDelayHours;

    public float $monthlyWithdrawalLimit;
    public float $validatedWithdrawalsValue;
    public int $monthlyWithdrawalsNumber;

    public string $cta;
    public string $bonusTitle;
    public string $bonusDescription;

    /**
     * @param string $id
     * @param string $name
     * @param string $logoUrl
     * @param float $averageRtp
     * @param float $biggestWinMonth
     * @param int $paymentDelayHours
     * @param float $monthlyWithdrawalLimit
     * @param float $validatedWithdrawalsValue
     * @param int $monthlyWithdrawalsNumber
     * @param string $cta
     * @param string $bonusTitle
     * @param string $bonusDescription
     */
    public function __construct(
        string $id,
        string $name,
        string $logoUrl = '',
        float $averageRtp = 0.0,
        float $biggestWinMonth = 0.0,
        int $paymentDelayHours = 0,
        float $monthlyWithdrawalLimit = 0.0,
        float $validatedWithdrawalsValue = 0.0,
        int $monthlyWithdrawalsNumber = 0,
        string $cta = '',
        string $bonusTitle = '',
        string $bonusDescription = ''
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->logoUrl = $logoUrl;

        $this->averageRtp = $averageRtp;
        $this->biggestWinMonth = $biggestWinMonth;
        $this->paymentDelayHours = $paymentDelayHours;
        $this->monthlyWithdrawalLimit = $monthlyWithdrawalLimit;
        $this->validatedWithdrawalsValue = $validatedWithdrawalsValue;
        $this->monthlyWithdrawalsNumber = $monthlyWithdrawalsNumber;

        $this->cta = $cta;
        $this->bonusTitle = $bonusTitle;
        $this->bonusDescription = $bonusDescription;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
