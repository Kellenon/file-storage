<?php

declare(strict_types=1);

namespace App\Services\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as MainSerializer;

/**
 * @link https://symfony.ru/doc/current/components/serializer.html
 */
final class Serializer
{
    /**
     * @param $data
     * @param string $format
     * @param array $context
     * @return string
     */
    public function serialize($data, string $format = 'json', array $context = []): string
    {
        return $this->getSerializer()->serialize($data, $format, $context);
    }

    /**
     * @param $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return mixed
     */
    public function deserialize($data, string $type, string $format = 'json', array $context = []): mixed
    {
        return $this->getSerializer()->deserialize($data, $type, $format, $context);
    }

    private function getSerializer(): MainSerializer
    {
        $extractor = new PropertyInfoExtractor([],
            [
                new PhpDocExtractor(),
                new ReflectionExtractor(),
            ]);
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()->disableMagicMethods()->getPropertyAccessor();
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $encoders = [
            new JsonEncoder(),
            new XmlEncoder(),
        ];
        $normalizers = [
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new DateTimeZoneNormalizer(),
            new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, $propertyAccessor, $extractor),
        ];

        return new MainSerializer($normalizers, $encoders);
    }
}
