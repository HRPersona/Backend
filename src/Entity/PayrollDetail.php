<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Salary\Model\BenefitAwareInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\PayrollAwareInterface;
use Persona\Hris\Salary\Model\PayrollDetailInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sa_payroll_details", indexes={
 *     @ORM\Index(name="payroll_detail_search_idx", columns={"payroll_id", "benefit_id"}),
 *     @ORM\Index(name="payroll_detail_search_payroll_id", columns={"payroll_id"}),
 *     @ORM\Index(name="payroll_detail_search_benefit", columns={"benefit_id"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class PayrollDetail implements PayrollDetailInterface, PayrollAwareInterface, BenefitAwareInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollId;

    /**
     * @var PayrollInterface
     */
    private $payroll;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $benefitId;

    /**
     * @var BenefitInterface
     */
    private $benefit;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $benefitType;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $benefitValue;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPayrollId(): string
    {
        return (string) $this->payrollId;
    }

    /**
     * @param string $payrollId
     */
    public function setPayrollId(string $payrollId = null)
    {
        $this->payrollId = $payrollId;
    }

    /**
     * @return PayrollInterface
     */
    public function getPayroll(): ? PayrollInterface
    {
        return $this->payroll;
    }

    /**
     * @param PayrollInterface $payroll
     */
    public function setPayroll(PayrollInterface $payroll = null): void
    {
        $this->payroll = $payroll;
        if ($payroll) {
            $this->payrollId = $payroll->getId();
        }
    }

    /**
     * @return string
     */
    public function getBenefitId(): string
    {
        return (string) $this->benefitId;
    }

    /**
     * @param string $benefitId
     */
    public function setBenefitId(string $benefitId = null)
    {
        $this->benefitId = $benefitId;
    }

    /**
     * @return BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface
    {
        return $this->benefit;
    }

    /**
     * @param BenefitInterface $benefit
     */
    public function setBenefit(BenefitInterface $benefit = null): void
    {
        $this->benefit = $benefit;
        if ($benefit) {
            $this->benefitId = $benefit->getId();
        }
    }

    /**
     * @return string
     */
    public function getBenefitType(): string
    {
        return $this->benefitType;
    }

    /**
     * @param string $benefitType
     */
    public function setBenefitType(string $benefitType): void
    {
        $benefitType = strtolower($benefitType);
        if (!in_array($benefitType, [BenefitInterface::TYPE_PLUS, BenefitInterface::TYPE_MINUS])) {
            throw new \InvalidArgumentException(sprintf('%s is not valid benefit type', $benefitType));
        }

        $this->benefitType = $benefitType;
    }

    /**
     * @return float
     */
    public function getBenefitValue(): float
    {
        return $this->benefitValue;
    }

    /**
     * @param float $benefitValue
     */
    public function setBenefitValue(float $benefitValue)
    {
        $this->benefitValue = $benefitValue;
    }
}
