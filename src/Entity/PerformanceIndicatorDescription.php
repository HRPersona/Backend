<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Performance\Model\IndicatorAwareInterface;
use Persona\Hris\Performance\Model\IndicatorDescriptionInterface;
use Persona\Hris\Performance\Model\IndicatorInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ap_indicator_descriptions", indexes={@ORM\Index(name="indicator_description_search_idx", columns={"indicator_id"})})
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
class PerformanceIndicatorDescription implements IndicatorDescriptionInterface, IndicatorAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $indicatorId;

    /**
     * @var IndicatorInterface
     */
    private $indicator;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $appraisalValue;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $description;

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
    public function getIndicatorId(): string
    {
        return (string) $this->indicatorId;
    }

    /**
     * @param string $indicatorId
     */
    public function setIndicatorId(string $indicatorId = null)
    {
        $this->indicatorId = $indicatorId;
    }

    /**
     * @return IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface
    {
        return $this->indicator;
    }

    /**
     * @param IndicatorInterface $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void
    {
        $this->indicator = $indicator;
        if ($indicator) {
            $this->indicatorId =  $indicator->getId();
        }
    }

    /**
     * @return int
     */
    public function getAppraisalValue(): int
    {
        return $this->appraisalValue;
    }

    /**
     * @param int $appraisalValue
     */
    public function setAppraisalValue(int $appraisalValue)
    {
        $this->appraisalValue = $appraisalValue;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}
