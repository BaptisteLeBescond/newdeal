<?php
namespace AppBundle\Services\Payslip;

use AppBundle\Repository\PmssRepository;

class PayslipCotisations
{
    private $pmssRepository;

    public function __construct(PmssRepository $pmssRepository) {
        $this->pmssRepository = $pmssRepository;
    }

    public function getCotisations($year, $month)
    {
        $pmss = $this->pmssRepository->findOneBy(
            array(
                'year' => $year,
                'month' => $month,
                'type' => 'pmss'
            )
        );
        $smic = $this->pmssRepository->findOneBy(
            array(
                'year' => $year,
                'month' => $month,
                'type' => 'smic'
            )
        );

        $cot = [];

        $cot['pmss']	= $pmss->getValue();   // Actualisé en début d'année (janvier)
        $cot['smic']	= $smic->getValue();   // Actualisé à une date aléatoire

        return $cot;
    }
}