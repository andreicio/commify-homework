<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Salary;
use App\SalaryCalculator\UkCalculator;
use App\SalaryCalculator\RoCalculator;
use Money\Parser\DecimalMoneyParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SalaryCalculatorController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return parent::getSubscribedServices() + [
                'GBPCalculator' => UkCalculator::class,
                'RONCalculator' => RoCalculator::class,
            ];
    }

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DecimalMoneyParser  $decimalMoneyParser,
    )
    {
    }

    #[Route('/salary/from-gross', name: 'from-gross', methods: ['GET'], format: 'json')]
    public function netFromGross(#[MapQueryString(validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY)] Salary $grossSalary): Response
    {
        $money = $this->decimalMoneyParser->parse($grossSalary->amount, $grossSalary->currency);

        $calculator = $grossSalary->currency . 'Calculator';

        $salaryBreakdown = $this->container->get($calculator)->fromGross($money);
$this->json($salaryBreakdown);
        return new JsonResponse($this->serializer->serialize($salaryBreakdown, 'json'));
    }
}
