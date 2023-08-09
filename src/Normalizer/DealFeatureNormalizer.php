<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\DealFeature;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DealFeatureNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        if ($object instanceof DealFeature && in_array('deal:read', $context['groups'] ?? [])) {
            return $this->normalizeDealFeature($object);
        }

        return [];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof DealFeature;
    }

    private function normalizeDealFeature(DealFeature $dealFeature): array
    {
        $feature = $dealFeature->getFeature();

        return $feature ? $feature->toArray() : [];
    }
}
