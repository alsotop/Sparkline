<?php

namespace Davaxi\Sparkline;

/**
 * Trait PointTrait.
 */
trait PointTrait
{
    /**
     * @var array
     */
    protected $points = [];

    /**
     * @param $index
     * @param $dotRadius
     * @param $colorHex
     */
    public function addPoint($index, $dotRadius, $colorHex)
    {
        $mapping = $this->getPointIndexMapping();
        if (array_key_exists($index, $mapping)) {
            $index = $mapping[$index];
            if ($index < 0) {
                return;
            }
        }
        $this->checkPointIndex($index);
        $this->points[] = [
            'index' => $index,
            'radius' => $dotRadius,
            'color' => $this->colorHexToRGB($colorHex),
        ];
    }

    /**
     * @return array
     */
    protected function getPointIndexMapping()
    {
        $count = $this->getCount();
        list($minIndex, $min, $maxIndex, $max) = $this->getExtremeValues();

        $mapping = [];
        $mapping['first'] = $count > 1 ? 0 : -1;
        $mapping['last'] = $count > 1 ? $count - 1 : -1;
        $mapping['minimum'] = $min !== $max ? $minIndex : -1;
        $mapping['maximum'] = $min !== $max ? $maxIndex : -1;

        return $mapping;
    }

    /**
     * @param $index
     */
    protected function checkPointIndex($index)
    {
        $count = $this->getCount();
        if (!is_numeric($index)) {
            throw new \InvalidArgumentException('Invalid index : ' . $index);
        }
        if ($index < 0 || $index >= $count) {
            throw new \InvalidArgumentException('Index out of range [0-' . ($count - 1) . '] : ' . $index);
        }
    }
}
