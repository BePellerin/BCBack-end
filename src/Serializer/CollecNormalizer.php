<?php
// api/src/Serializer/MediaObjectNormalizer.php

namespace App\Serializer;

use App\Entity\AirDrop;
use App\Entity\Collecs;
use App\Entity\MediaObject;
use App\Entity\Nft;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class CollecNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(private StorageInterface $storage)
    {
    }

    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $object->contentUrlAvatar = $this->storage->resolveUri($object, 'avatarPict');
        $object->contentUrlCover = $this->storage->resolveUri($object, 'coverPict');

        // $object->contentUrlAvatar = str_replace(' ', '_', $this->storage->resolveUri($object, 'avatarPict'));
        // $object->contentUrlCover = str_replace(' ', '_', $this->storage->resolveUri($object, 'coverPict'));

        return $this->normalizer->normalize($object, $format, $context);
    }



    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Collecs;
    }
}
