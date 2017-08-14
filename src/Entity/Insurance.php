<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Insurance\Model\InsuranceInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\MinusBenefitAwareInterface;
use Persona\Hris\Salary\Model\PlusBenefitAwareInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="in_insurances", indexes={
 *     @ORM\Index(name="insurance_search_idx", columns={"name", "plus_benefit_id", "minus_benefit_id"}),
 *     @ORM\Index(name="insurance_search_name", columns={"name"}),
 *     @ORM\Index(name="insurance_search_plus_benefit", columns={"plus_benefit_id"}),
 *     @ORM\Index(name="insurance_search_minus_benefit", columns={"minus_benefit_id"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter", "name.search", "formula.search"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("name")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Insurance implements InsuranceInterface, PlusBenefitAwareInterface, MinusBenefitAwareInterface, ActionLoggerAwareInterface
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $plusBenefitId;

    /**
     * @var BenefitInterface
     */
    private $plusBenefit;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $minusBenefitId;

    /**
     * @var BenefitInterface
     */
    private $minusBenefit;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $formulaId;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPlusBenefitId(): string
    {
        return $this->plusBenefitId;
    }

    /**
     * @param string $plusBenefitId
     */
    public function setPlusBenefitId(string $plusBenefitId = null)
    {
        $this->plusBenefitId = $plusBenefitId;
    }

    /**
     * @return BenefitInterface
     */
    public function getPlusBenefit(): ? BenefitInterface
    {
        return $this->plusBenefit;
    }

    /**
     * @param BenefitInterface $plusBenefit
     */
    public function setPlusBenefit(BenefitInterface $plusBenefit = null): void
    {
        $this->plusBenefit = $plusBenefit;
        if ($plusBenefit) {
            $this->plusBenefitId = $plusBenefit->getId();
        }
    }

    /**
     * @return string
     */
    public function getMinusBenefitId(): string
    {
        return $this->minusBenefitId;
    }

    /**
     * @param string $minusBenefitId
     */
    public function setMinusBenefitId(string $minusBenefitId = null)
    {
        $this->minusBenefitId = $minusBenefitId;
    }

    /**
     * @return BenefitInterface
     */
    public function getMinusBenefit(): ? BenefitInterface
    {
        return $this->minusBenefit;
    }

    /**
     * @param BenefitInterface $minusBenefit
     */
    public function setMinusBenefit(BenefitInterface $minusBenefit = null): void
    {
        $this->minusBenefit = $minusBenefit;
        if ($minusBenefit) {
            $this->minusBenefitId = $minusBenefit->getId();
        }
    }

    /**
     * @return string
     */
    public function getFormulaId(): string
    {
        return $this->formulaId;
    }

    /**
     * @param string $formulaId
     */
    public function setFormulaId(string $formulaId)
    {
        $this->formulaId = $formulaId;
    }
}
