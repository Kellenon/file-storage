<?php

declare(strict_types=1);

namespace App\Services\Serializer;

use App\Services\Serializer\Normalizer\CollectionNormalizer;
use ArrayObject;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @link https://symfony.ru/doc/current/serializer/normalizers.html
 */
final class Normalizer
{
    /**
     * @param $data
     * @param string|null $format
     * @param array $context
     * @return string|array|bool|ArrayObject|int|float|null
     * @throws ExceptionInterface
     */
    public function normalize($data, string $format = null, array $context = []): string|array|bool|ArrayObject|int|null|float
    {
        return $this->getSerializer()->normalize($data, $format, $context);
    }

    /**
     * @param $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return mixed
     * @throws ExceptionInterface
     */
    public function denormalize($data, string $type, string $format = null, array $context = [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]): mixed
    {
        return $this->getSerializer()->denormalize($data, $type, $format, $context);
    }

    private function getSerializer(): Serializer
    {
        $extractor = new PropertyInfoExtractor([],
            [
                new PhpDocExtractor(),
                new ReflectionExtractor(),
            ]);
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()->disableMagicMethods()->getPropertyAccessor();
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $normalizers = [
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new CollectionNormalizer(),
            new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, $propertyAccessor, $extractor),
        ];

        return new Serializer($normalizers);
    }
}
