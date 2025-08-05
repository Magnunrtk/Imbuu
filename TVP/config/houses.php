<?php

declare(strict_types=1);

return [
    'imagePath' => public_path() . '/assets/media/houses/',
    'notFoundPath' => public_path() . '/assets/media/',
    'imageExtension' => '.png',
    'houseAuctionEnable' => true,
    'houseTransferEnable' => true,
    'minimumLevelToPlaceBid' => 8,
    'needPremiumAccountToOwnHouse' => true,
    'houseAuctionTimeInDays' => 1,
    'rentPricePerSqm' => 50,
];
