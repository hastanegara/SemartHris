<?php

namespace KejawenLab\Application\SemartHris\Component\Overtime\Service;

use KejawenLab\Application\SemartHris\Component\Attendance\Repository\WorkshiftRepositoryInterface;
use KejawenLab\Application\SemartHris\Component\Overtime\Calculator\OvertimeCalculator as Calculator;
use KejawenLab\Application\SemartHris\Component\Overtime\Model\OvertimeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
final class OvertimeCalculator
{
    /**
     * @var OvertimeChecker
     */
    private $checker;

    /**
     * @var Calculator
     */
    private $calculator;

    /**
     * @var WorkshiftRepositoryInterface
     */
    private $workshiftRepository;

    /**
     * @var int
     */
    private $workDay;

    /**
     * @param OvertimeChecker              $checker
     * @param Calculator                   $calculator
     * @param WorkshiftRepositoryInterface $repository
     * @param int                          $workDayPerWeek
     */
    public function __construct(OvertimeChecker $checker, Calculator $calculator, WorkshiftRepositoryInterface $repository, int $workDayPerWeek)
    {
        $this->checker = $checker;
        $this->calculator = $calculator;
        $this->workshiftRepository = $repository;
        $this->workDay = $workDayPerWeek;
    }

    /**
     * @param OvertimeInterface $overtime
     */
    public function calculate(OvertimeInterface $overtime): void
    {
        if (!$this->checker->allowToOvertime($overtime)) {
            return;
        }

        if (!$overtime->getEndHour()) {
            return;
        }

        $workshift = $this->workshiftRepository->findByEmployeeAndDate($overtime->getEmployee(), $overtime->getOvertimeDate());
        if (!$workshift) {
            return;
        }

        $overtime->setShiftment($workshift->getShiftment());
        $this->calculator->setWorkdayPerWeek($this->workDay);
        $this->calculator->calculate($overtime);
    }
}
