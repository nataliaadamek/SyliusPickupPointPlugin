<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusPickupPointPlugin\Behat\Mocker;

use Setono\SyliusPickupPointPlugin\Model\PickupPoint;
use Setono\SyliusPickupPointPlugin\Model\PickupPointInterface;
use Setono\SyliusPickupPointPlugin\Provider\ProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GlsProviderMocker implements ProviderInterface
{
    const PICKUP_POINT_ID = '001';

    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCode(): string
    {
        return 'gls';
    }

    public function getName(): string
    {
        return 'GLS';
    }

    public function findPickupPoints(OrderInterface $order): array
    {
        return [
            [
                'id' => '1',
                'name' => 'Somewhere',
                'address' => 'Rainbow',
                'zipCode' => '12345',
                'city' => 'Nice City',
                'country' => 'Nice City',
            ],
            [
                'id' => '2',
                'name' => 'test',
                'address' => 'test2',
                'zipCode' => '12345',
                'city' => 'Nice City',
                'country' => 'Nice City',
            ],
            [
                'id' => '3',
                'name' => 'Other place',
                'address' => 'Point',
                'zipCode' => '12345',
                'city' => 'Other City',
                'country' => 'Other Country',
            ],
            [
                'id' => '4',
                'name' => '4 place',
                'address' => 'Point',
                'zipCode' => '12345',
                'city' => 'Other City',
                'country' => 'Other Country',
            ],
        ];
    }

    public function getPickupPointById(string $id): ?PickupPointInterface
    {
        return new PickupPoint(
            self::PICKUP_POINT_ID,
            'Somewhere',
            'Rainbow',
            '12345',
            'Nice City',
            'Nice City',
            '',
            ''
        );
    }

    public function getClient(): \SoapClient
    {
        return $this->container->get('setono.sylius_pickup_point.provider.gls')->getClient();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return true;
    }
}
