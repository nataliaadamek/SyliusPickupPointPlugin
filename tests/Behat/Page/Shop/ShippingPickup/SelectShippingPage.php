<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusPickupPointPlugin\Behat\Page\Shop\ShippingPickup;

use Sylius\Behat\Page\Shop\Checkout\SelectShippingPage as BaseSelectShippingPage;

final class SelectShippingPage extends BaseSelectShippingPage implements SelectShippingPageInterface
{
    public function chooseFirstShippingPointFromCheckbox(): void
    {
        $this->getDocument()->waitFor(5, function () {
            return $this->hasElement('pickup_point_checkbox');
        });

        $checkbox = $this->getElement('pickup_point_checkbox');

        $checkbox->click();

        $item = $this->getElement('pickup_point_checkbox_item', [
            '%value%' => '001',
        ]);

        $item->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'pickup_point_checkbox' => '.pickup-point-checkbox',
            'pickup_point_checkbox_item' => '.pickup-point-checkbox div.item[data-value="%value%"]',
        ]);
    }
}
