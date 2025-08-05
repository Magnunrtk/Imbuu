<?php

declare(strict_types=1);

use App\Http\Controllers\Account\AccountCreateController;
use App\Http\Controllers\Account\Auth\AccountChangePasswordController;
use App\Http\Controllers\Account\Auth\AccountPremiumHistoryController;
use App\Http\Controllers\Account\Auth\AccountRecoveryKeyController;
use App\Http\Controllers\Account\Auth\AccountTellAFriendController;
use App\Http\Controllers\Account\Auth\AccountUnbanController;
use App\Http\Controllers\Account\Auth\LoginController;
use App\Http\Controllers\StreamerAuthController;
use App\Http\Controllers\StreamerDashboardController;

use App\Http\Controllers\Account\Auth\LostAccountController;
use App\Http\Controllers\Account\NewPasswordController;
use App\Http\Controllers\Account\ResetPasswordController;

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminSpriteHDController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HousesController;
use App\Http\Controllers\Admin\McTransactionsController;
use App\Http\Controllers\Admin\ClientUpdateController;
use App\Http\Controllers\Admin\SearchPaymentController;
use App\Http\Controllers\Admin\Store\PaymentOptionsController;
use App\Http\Controllers\Admin\Store\ProductsController;
use App\Http\Controllers\Admin\TcTransactionsController;

use App\Http\Controllers\Admin\StreamerReferencesController;
use App\Http\Controllers\TwitchLiveController;

use App\Http\Controllers\Admin\TimeClockController;
use App\Http\Controllers\Admin\EmployeeController;

use App\Http\Controllers\BazaarController;
use App\Http\Controllers\DeleteCharacterController;
use App\Http\Controllers\BansController;
use App\Http\Controllers\Character\Auth\CreateCharacterController;
use App\Http\Controllers\Character\Auth\EditCharacterController;
use App\Http\Controllers\Character\SearchCharacterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Email\Auth\AccountChangeEmailController;
use App\Http\Controllers\Email\EmailController;
use App\Http\Controllers\Guild\CreateGuildController;
use App\Http\Controllers\Guild\GuildManagementController;
use App\Http\Controllers\Guild\GuildsListController;
use App\Http\Controllers\Guild\GuildViewController;
use App\Http\Controllers\Guild\MyGuildApplicationController;
use App\Http\Controllers\HighscoreListController;
use App\Http\Controllers\House\Auth\HouseAuctionController;
use App\Http\Controllers\House\Auth\HouseManagementController;
use App\Http\Controllers\House\HousesListController;
use App\Http\Controllers\SecurityQuestionController;
use App\Http\Controllers\PurchaseHistoryController;

//Community
use App\Http\Controllers\KillStatisticsController;
use App\Http\Controllers\PowergamersController;
use App\Http\Controllers\LastBansController;

use App\Http\Controllers\LatestDeathsController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\Payment\MediviaCoinsController;
use App\Http\Controllers\Payment\MercadoPagoWebhookController;
use App\Http\Controllers\Payment\PayPalWebhookController;
use App\Http\Controllers\Payment\StripeWebhookController;
use App\Http\Controllers\Payment\TibiaCoinsController;

use App\Http\Controllers\PaymentPackages\PackagesMercadoPagoWebhookController;
use App\Http\Controllers\PaymentPackages\PackagesStripeWebhookController;

use App\Http\Controllers\PlayersOnlineController;
use App\Http\Controllers\CrashReportController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\SecurityHintsController;
use App\Http\Controllers\SpellsController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\StreamersController;
use App\Http\Controllers\TellAFriendController;
use App\Utils\GuildRanks;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\VipAccumulatedController;

use App\Http\Controllers\Api\MercadoPagoApiController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\GetCoinsWebhookController;
use App\Utils\PlayersOnlineCache;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MailProcesserController;

// Exemplo de rota
Route::post('/send-email', [MailController::class, 'sendCustomEmail']);
Route::get('/process-emails', [MailProcesserController::class, 'processEmailQueue']);


Route::get('/players-online-count', function () {
    return response()->json(['count' => PlayersOnlineCache::getAll()]);
});

Route::post('/api/payment-webhook', [PaymentWebhookController::class, 'handleWebhook']);
Route::post('/api/payment-webhookMP', [GetCoinsWebhookController::class, 'handleWebhook']);

Route::get('/ref/{referral?}', [TellAFriendController::class, 'index'])->name('tell-a-friend');

Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
    Route::group(['prefix' => 'status', 'as' => 'status.'], function () {
        Route::get('/', function () {
            return view('status.index');
        });
    });
});

Route::get('/calculadora', function () {
    return view('template.teste');
});

Route::get('download/receipt/{filename}', function ($filename) {

    $filePath = storage_path('app/public/employee_payments_proof/' . $filename);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        return abort(404, 'Arquivo não encontrado');
    }
})->name('download.receipt');

Route::group(['prefix' => 'privacy', 'as' => 'privacy.'], function () {
    Route::group(['prefix' => 'terms', 'as' => 'terms.'], function () {
        Route::get('/', function () {
            return view('terms.index');
        })->name('index');
    });
});

Route::get('/', [NewsController::class, 'index'])->name('landing');
Route::get('/archive', [NewsController::class, 'archive'])->name('archive');
Route::get('/archive/{id}', [NewsController::class, 'archiveView'])->name('archiveView');


Route::group(['prefix' => 'download', 'as' => 'download.'], function () {
    Route::get('/', [DownloadController::class, 'index'])->name('index');
    Route::post('/', [DownloadController::class, 'prepare'])->name('prepare');
    Route::get('/start', [DownloadController::class, 'start'])->name('start');
});

Route::group(['middleware' => ['guest']], function () {
    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {

        Route::post('/check-id', [AccountCreateController::class, 'checkId'])->name('check.id');
        Route::post('/check-email', [AccountCreateController::class, 'checkEmail'])->name('check.email');
        Route::post('/check-account-id', [AccountCreateController::class, 'checkAccountId'])->name('check.account.id');
        Route::post('/check-character-name', [AccountCreateController::class, 'checkCharacterName'])->name('check.character.name');

        Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
            Route::get('/', [AccountCreateController::class, 'index'])->name('index');
            Route::post('/', [AccountCreateController::class, 'create'])->name('store');
        });
        Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
            Route::get('/', [AuthController::class, 'index'])->name('index');
            Route::post('/', [AuthController::class, 'validateLogin'])->name('loginPost');
        });
        Route::group(['prefix' => 'lost', 'as' => 'lost.'], function () {

            Route::get('/', [LostAccountController::class, 'index'])->name('index');
            Route::post('/', [LostAccountController::class, 'action'])->name('action');
            
            Route::group(['prefix' => 'confirm', 'as' => 'confirm.'], function () {
                Route::get('/{confirmationKey?}', [LostAccountController::class, 'confirmEmail'])->name('index');
                Route::post('/', [LostAccountController::class, 'confirmAction'])->name('action');
            });

            Route::group(['prefix' => 'new', 'as' => 'new.'], function () {
                Route::get('/{confirmationKey?}', [LostAccountController::class, 'confirmNewPassword'])->name('index');
                Route::post('/', [LostAccountController::class, 'newPasswordAction'])->name('action');
            });
        });

        Route::group(['prefix' => 'reset', 'as' => 'reset.'], function () {

            Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
                Route::get('/', [ResetPasswordController::class, 'index'])->name('index');
                Route::post('/', [ResetPasswordController::class, 'resetPassword'])->name('action');
                Route::group(['prefix' => 'new', 'as' => 'new.'], function () {
                    Route::get('/', [NewPasswordController::class, 'index'])->name('index');
                    Route::post('/', [NewPasswordController::class, 'setNewPassword'])->name('action');
                });
            });

        });
    });
});

Route::get('/first-login', function () {
    return view('auth.first-login');
})->name('first-login');

Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
    Route::group(['prefix' => 'confirm', 'as' => 'confirm.'], function () {
        Route::get('/{emailHash}/{confirmationKey}', [EmailController::class, 'index'])->name('index');
        Route::get('/recovery-key/{emailHash}/{confirmationKey}', [EmailController::class, 'confirmRecoveryKey'])->name('confirmRecoveryKey');
        Route::post('/{emailHash}/{confirmationKey}', [EmailController::class, 'checkRecoveryKey'])->name('checkRecoveryKey');
        Route::post('/', [EmailController::class, 'confirmAccount'])->name('action');
    });
});

Route::group(['prefix' => 'about', 'as' => 'about.'], function () {


    Route::get('/', function () {
        return view('about.game.index');
    })->name('game');

    Route::get('/creatures', function () {
        return view('about.wiki.creatures');
    })->name('creatures');

    Route::get('/creaturesView/{name}', function ($name) {
        return view('about.wiki.creaturesView', ['name' => $name]);
    })->name('creaturesView');

    Route::get('/items', function () {
        return view('about.wiki.items');
    })->name('items');

    Route::get('/itemPage/{name}', function ($name) {
        return view('about.wiki.itemPage', ['item' => $name]);
    })->name('itemPage');

    Route::get('/map', function () {
        return view('about.wiki.map');
    })->name('map');

    Route::get('/charms', function () {
        return view('about.wiki.charms');
    })->name('charms');

    Route::get('/spellView/{name}', function ($name) {
        return view('about.wiki.spellView', ['name' => $name]);
    })->name('spellView');

    Route::get('/npcs', function () {
        return view('about.wiki.npcs');
    })->name('npcs');

    Route::get('/npcs/{name}', function ($name) {
        return view('about.wiki.npcsView', ['name' => $name]);
    })->name('npcsView');

    Route::get('/statGuide', function () {
        return view('about.wiki.statGuide');
    })->name('statGuide');

    Route::get('/marketOffline', function () {
        return view('about.wiki.marketOffline');
    })->name('marketOffline');

    Route::get('/rarityUpgrade', function () {
        return view('about.wiki.rarityUpgrade');
    })->name('rarityUpgrade');

    Route::get('/itemsView/{name}', function ($name) {
        return view('about.wiki.itemsView', ['item' => $name]);
    })->name('itemsView');

    Route::get('/game-features', function () {
        return view('about.game-features.index');
    })->name('game-features');

    if (config('server.enableGoldenAccount')) {
        Route::get('/golden-features', function () {
            return view('about.golden-features.index');
        })->name('golden-features');
    }

    if (config('server.enablePremiumAccount')) {
        Route::get('/premium-features', function () {
            return view('about.premium-features.index');
        })->name('premium-features');
    }
});

Route::group(['prefix' => 'support', 'as' => 'support.'], function () {
    Route::get('/rules', [RulesController::class, 'index'])->name('rules');
    Route::get('/security-hints', [SecurityHintsController::class, 'index'])->name('securityHints');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
});

Route::group(['prefix' => 'library', 'as' => 'library.'], function () {
    Route::get('/shared-experience', function () {
        return view('library.shared-experience.index');
    })->name('shared-experience');
    Route::group(['prefix' => 'spells', 'as' => 'spells.'], function () {
        Route::get('/', [SpellsController::class, 'index'])->name('index');
        Route::post('/', [SpellsController::class, 'filter'])->name('filter');
    });
});

Route::get('/players-online/emac', [PlayersOnlineController::class, 'playersOnlineEmac'])->name('playersOnlineEmac');
Route::post('/crash-report', [CrashReportController::class, 'create'])->name('crashReport.create');
Route::get('/read-report/{filename}', [CrashReportController::class, 'read'])->name('crashReport.read');

Route::group(['prefix' => 'community', 'as' => 'community.'], function () {
    Route::group(['prefix' => 'latest-deaths', 'as' => 'latest-deaths.'], function () {
        Route::get('/', [LatestDeathsController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'streamers', 'as' => 'streamers.'], function () {
        Route::get('/', [StreamersController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'players-online', 'as' => 'players-online.'], function () {
        Route::post('/', [PlayersOnlineController::class, 'selectWorldAction'])->name('selectWorldAction');
        if (config('multi_world.enabled')) {
            Route::get('/', [PlayersOnlineController::class, 'selectWorld'])->name('selectWorld');
            Route::group(['prefix' => '{worldSlug}', 'middleware' => ['world']], function () {
                Route::get('/{sort?}', [PlayersOnlineController::class, 'index'])->name('index');
            });
        } else {
            Route::get('/{sort?}', [PlayersOnlineController::class, 'indexNoWorld'])->name('index');
        }
    });

    Route::group(['prefix' => 'houses', 'as' => 'houses.'], function () {
        Route::get('/', [HousesListController::class, 'index'])->name('index');
        Route::post('/', [HousesListController::class, 'loadList'])->name('loadList');
        if (config('multi_world.enabled')) {
            Route::group(['prefix' => '{worldSlug}', 'middleware' => ['world']], function () {
                Route::get('/{town}/{status}/{orderBy}', [HousesListController::class, 'list'])->name('list');
            });
        } else {
            Route::get('/{town}/{status}/{orderBy}', [HousesListController::class, 'listNoWorld'])->name('list');
        }
    });
    Route::group(['prefix' => 'guilds', 'as' => 'guilds.'], function () {
        Route::get('/', [GuildsListController::class, 'index'])->name('index');
        Route::post('/', [GuildsListController::class, 'loadList'])->name('loadList');
        Route::group(['prefix' => '{worldSlug}', 'middleware' => ['world']], function () {
            Route::get('/', [GuildsListController::class, 'list'])->name('list');
        });
    });
    if (config('server.enableHighscore')) {
        Route::group(['prefix' => 'highscores', 'as' => 'highscores.'], function () {
            if (config('multi_world.enabled')) {
                Route::group(['prefix' => '{worldSlug?}', 'middleware' => ['world']], function () {
                    Route::get('/', [HighscoreListController::class, 'index'])->name('index');
                    Route::post('/', [HighscoreListController::class, 'setFilter'])->name('action');
                    Route::get('/{skill}/{page}/{vocation?}', [HighscoreListController::class, 'filter'])->name('filter');
                });
            } else {
                Route::get('/', [HighscoreListController::class, 'indexNoWorld'])->name('index');
                Route::post('/', [HighscoreListController::class, 'setFilterNoWorld'])->name('action');
                Route::get('/{skill}/{page}/{vocation?}', [HighscoreListController::class, 'filterNoWorld'])->name('filter');
            }
        });
    }

    Route::group(['prefix' => 'kill-statistics', 'as' => 'kill-statistics.'], function () {
        Route::get('/', [KillStatisticsController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'powergamers', 'as' => 'powergamers.'], function () {
        Route::get('/', [PowergamersController::class, 'index'])->name('index');
    });  

    Route::group(['prefix' => 'last-bans', 'as' => 'last-bans.'], function () {
        Route::get('/', [LastBansController::class, 'index'])->name('index');
    });
    
    Route::group(['prefix' => 'guild', 'as' => 'guild.'], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
                Route::get('/', [CreateGuildController::class, 'index'])->name('index');
                Route::post('/', [CreateGuildController::class, 'create'])->name('action');
            });
        });
    });
    Route::group(['prefix' => 'view', 'as' => 'view.'], function () {
        Route::group(['prefix' => 'character', 'as' => 'character.'], function () {
            Route::get('/', [SearchCharacterController::class, 'searchView'])->name('searchView');
            Route::post('/', [SearchCharacterController::class, 'searchPost'])->name('searchPost');
            Route::group(['prefix' => '{characterName}', 'middleware' => ['player']], function () {
                Route::get('/', [SearchCharacterController::class, 'search'])->name('search');
            });
        });
        Route::group(['prefix' => 'house', 'as' => 'house.'], function () {
            Route::group(['prefix' => '{houseId}', 'middleware' => ['house']], function () {

                Route::get('/', [HousesListController::class, 'view'])->name('index');
                
                Route::group(['middleware' => ['auth']], function () {
                    Route::group(['prefix' => 'manage', 'as' => 'manage.'], function () {
                        Route::group(['prefix' => 'keep-house', 'as' => 'keep-house.'], function () {
                            Route::get('/', [HouseManagementController::class, 'keepHouse'])->name('index');
                            Route::post('/', [HouseManagementController::class, 'keepHouseAction'])->name('action');
                        });
                        Route::group(['prefix' => 'move-out', 'as' => 'move-out.'], function () {
                            Route::get('/', [HouseManagementController::class, 'moveOut'])->name('index');
                            Route::post('/', [HouseManagementController::class, 'moveOutAction'])->name('action');
                        });
                        Route::group(['prefix' => 'transfer', 'as' => 'transfer.'], function () {
                            Route::get('/', [HouseManagementController::class, 'transfer'])->name('index');
                            Route::post('/', [HouseManagementController::class, 'transferAction'])->name('action');
                            Route::group(['prefix' => 'accept', 'as' => 'accept.'], function () {
                                Route::get('/', [HouseManagementController::class, 'accept'])->name('index');
                                Route::post('/', [HouseManagementController::class, 'acceptAction'])->name('action');
                            });
                        });
                    });
                    Route::group(['prefix' => 'auction', 'as' => 'auction.'], function () {
                        Route::get('/', [HouseAuctionController::class, 'index'])->name('index');
                        Route::group(['prefix' => 'bid', 'as' => 'bid.'], function () {
                            Route::post('/', [HouseAuctionController::class, 'placeBid'])->name('action');
                        });
                    });
                });
            });
        });
        Route::group(['prefix' => 'guild', 'as' => 'guild.'], function () {
            Route::group(['prefix' => '{guildName}', 'middleware' => ['guild']], function () {
                Route::get('/', [GuildViewController::class, 'view'])->name('index');
                Route::group(['middleware' => ['auth']], function () {
                    Route::group(['prefix' => 'manage', 'as' => 'manage.'], function () {
                        Route::group(['prefix' => 'rank', 'as' => 'rank.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'rank'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'updateRankNumber'])->name('updateNumberOfRank');
                            Route::post('/name', [GuildManagementController::class, 'updateRankName'])->name('updateRankName');
                        });
                        Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL . ',' . GuildRanks::VICE_LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'member'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'memberAction'])->name('action');
                        });
                        Route::group(['prefix' => 'leave', 'as' => 'leave.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL . ',' . GuildRanks::VICE_LEADER_LEVEL . ',' . GuildRanks::MEMBER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'leave'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'leaveAction'])->name('action');
                        });
                        Route::group(['prefix' => 'join', 'as' => 'join.'], function () {
                            Route::get('/', [GuildManagementController::class, 'join'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'joinAction'])->name('action');
                        });
                        Route::group(['prefix' => 'invite', 'as' => 'invite.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL . ',' . GuildRanks::VICE_LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'invite'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'inviteAction'])->name('action');
                            Route::group(['prefix' => 'cancel', 'as' => 'cancel.'], function () {
                                Route::post('/', [GuildManagementController::class, 'cancelInvite'])->name('action');
                            });
                        });
                        Route::group(['prefix' => 'disband', 'as' => 'disband.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'disband'])->name('index');
                            Route::post('/', [GuildManagementController::class, 'disbandAction'])->name('action');
                        });
                        Route::group(['prefix' => 'applications', 'as' => 'applications.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL . ',' . GuildRanks::VICE_LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'applications'])->name('index');
                            Route::post('/deny', [GuildManagementController::class, 'denyApplications'])->name('deny');
                            Route::post('/allow', [GuildManagementController::class, 'allowApplications'])->name('allow');
                            Route::get('/accept/{name}', [GuildManagementController::class, 'acceptApplication'])->name('accept');
                            Route::get('/reject/{name}', [GuildManagementController::class, 'rejectApplication'])->name('reject');
                        });
                        Route::group(['prefix' => 'edit', 'as' => 'edit.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL]], function () {
                            Route::get('/', [GuildManagementController::class, 'edit'])->name('index');
                            Route::group(['prefix' => 'description', 'as' => 'description.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL]], function () {
                                Route::post('/', [GuildManagementController::class, 'descriptionAction'])->name('action');
                            });
                            Route::group(['prefix' => 'logo', 'as' => 'logo.', 'middleware' => ['guild_rank:' . GuildRanks::LEADER_LEVEL]], function () {
                                Route::post('/', [GuildManagementController::class, 'logoAction'])->name('action');
                            });
                        });
                    });
                    Route::group(['prefix' => 'my', 'as' => 'my.'], function () {
                        Route::group(['prefix' => 'applications', 'as' => 'applications.'], function () {
                            Route::get('/', [MyGuildApplicationController::class, 'index'])->name('index');
                            Route::post('/', [MyGuildApplicationController::class, 'store'])->name('apply');
                            Route::get('/withdraw/{name}', [MyGuildApplicationController::class, 'withdraw'])->name('withdraw');
                        });
                    });
                });
            });
        });
    });
});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {

        Route::get('/', [LoginController::class, 'index'])->name('index');

        Route::post('/store-vip-accumulated', [VipAccumulatedController::class, 'storeVipAccumulated']);
        Route::post('/bonus-give', [VipAccumulatedController::class, 'bonusGive']);
                        
        Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
            Route::group(['prefix' => 'confirmation', 'as' => 'confirmation.'], function () {
                Route::group(['prefix' => 'change', 'as' => 'change.'], function () {
                    Route::get('/', [LoginController::class, 'changeConfirmationEmail'])->name('index');
                    Route::post('/', [LoginController::class, 'changeConfirmationEmailAction'])->name('action');
                });
                Route::post('/resend', [LoginController::class, 'resendConfirmationEmail'])->name('action');
            });
        });

        Route::group(['prefix' => 'delete', 'as' => 'delete.'], function () {
            Route::post('/', [DeleteCharacterController::class, 'index'])->name('index');
            Route::post('/{id}', [DeleteCharacterController::class, 'action'])->name('action');
            Route::get('/', [DeleteCharacterController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'manage', 'as' => 'manage.'], function () {

            Route::get('/', [LoginController::class, 'manage'])->name('index');

            Route::get('/2fa/register', [LoginController::class, 'generateQRCode'])->name('2fa.register');
            Route::post('/verify-2fa', [LoginController::class, 'verify2FACode'])->name('verify2fa');

            Route::get('/security-questions/register', [SecurityQuestionController::class, 'showSetupForm'])->name('security-questions.register');
            Route::post('/security-questions/save', [SecurityQuestionController::class, 'saveSecurityQuestions'])->name('security-questions.save');

            Route::get('/purchase-history', [PurchaseHistoryController::class, 'index'])->name('purchase.history');

            Route::get('/streamer/login', [StreamerAuthController::class, 'index'])->name('streamer.login');
            Route::post('/streamer/login', [StreamerAuthController::class, 'login'])->name('streamer.login.submit');
            Route::get('/streamer/dashboard', [StreamerDashboardController::class, 'index'])->name('streamer.dashboard')->middleware('streamer.auth');
            Route::post('/streamer/logout', [StreamerAuthController::class, 'logout'])->name('streamer.logout');
            Route::post('/streamer/create-coupon', [StreamerDashboardController::class, 'createCoupon'])->name('streamer.createCoupon')->middleware('streamer.auth');
            Route::post('/streamer/update-coupon', [StreamerDashboardController::class, 'updateCoupon'])->name('streamer.updateCoupon')->middleware('streamer.auth');
            Route::post('/streamer/update-pix', [StreamerDashboardController::class, 'updatePixKey'])->name('streamer.updatePix')->middleware('streamer.auth');
            Route::post('/streamer/associate-account', [StreamerDashboardController::class, 'associateAccount'])->name('streamer.associateAccount')->middleware('streamer.auth');
            Route::post('/streamer/dissociate-account', [StreamerDashboardController::class, 'dissociateAccount'])->name('streamer.dissociateAccount')->middleware('streamer.auth');
            Route::get('/streamer/references-by-month', [StreamerDashboardController::class, 'getReferencesByMonth'])->name('streamer.referencesByMonth')->middleware('streamer.auth');
            Route::get('/streamer/monthly-earnings', [StreamerDashboardController::class, 'getMonthlyEarnings'])->name('streamer.monthlyEarnings')->middleware('streamer.auth');



            Route::group(['prefix' => 'tell-a-friend', 'as' => 'tell-a-friend.'], function () {
                Route::get('/', [AccountTellAFriendController::class, 'index'])->name('index');
                Route::post('/', [AccountTellAFriendController::class, 'create'])->name('create');
                Route::get('/statistics', [AccountTellAFriendController::class, 'statistics'])->name('statistics');
            });

            Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
                Route::get('/', [AccountChangeEmailController::class, 'index'])->name('index');
                Route::post('/', [AccountChangeEmailController::class, 'method'])->name('method');
                Route::post('cancel', [AccountChangeEmailController::class, 'cancelChangeEmail'])->name('cancel');
                Route::get('/confirm/{confirmationKey?}', [AccountChangeEmailController::class, 'viewConfirmRecoveryKey'])->name('confirm');
                Route::group(['prefix' => 'confirmation', 'as' => 'confirmation.'], function () {
                    Route::post('/resend', [LoginController::class, 'resendConfirmationEmail'])->name('action');
                });
            });
            Route::group(['prefix' => 'change', 'as' => 'change.'], function () {
                Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
                    Route::get('/', [AccountChangePasswordController::class, 'index'])->name('index');
                    Route::post('/', [AccountChangePasswordController::class, 'method'])->name('method');
                    Route::get('/confirm/{confirmationKey?}', [AccountChangePasswordController::class, 'viewConfirm'])->name('confirm');
                });
            });
            if (config('shop.extraServices')['recoveryKey']['enabled']) {
                Route::group(['prefix' => 'recovery-key', 'as' => 'recovery-key.'], function () {
                    Route::get('/', [AccountRecoveryKeyController::class, 'index'])->name('index');
                    Route::post('/', [AccountRecoveryKeyController::class, 'action'])->name('action');
                });
            }
            if (config('shop.extraServices')['unban']['enabled']) {
                Route::group(['prefix' => 'unban', 'as' => 'unban.'], function () {
                    Route::get('/', [AccountUnbanController::class, 'index'])->name('index');
                    Route::post('/', [AccountUnbanController::class, 'action'])->name('action');
                });
            }
        });
        
        Route::group(['prefix' => 'character', 'as' => 'character.'], function () {
            Route::group(['prefix' => 'create', 'as' => 'create.'], function () {
                Route::get('/', [CreateCharacterController::class, 'index'])->name('index');
                Route::post('/', [CreateCharacterController::class, 'create'])->name('action');
            });
            Route::group(['prefix' => 'edit', 'as' => 'edit.'], function () {
                Route::group(['prefix' => '{characterName}', 'middleware' => ['accountPlayer']], function () {
                    Route::get('/', [EditCharacterController::class, 'index'])->name('index');
                    Route::post('/', [EditCharacterController::class, 'edit'])->name('action');
                });
            });
        });

        if (config('shop.enabled')) {

            Route::group(['prefix' => 'store', 'as' => 'store.'], function () {

                Route::get('/', [StoreController::class, 'index'])->name('index');

                Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {

                    Route::get('/', [PackagesController::class, 'index'])->name('index');
                    Route::post('/', [PackagesController::class, 'action'])->name('action');

                    Route::group(['prefix' => 'payment-method', 'as' => 'payment-method.'], function () {
    
                        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
                            Route::get('/success', [PackagesStripeWebhookController::class, 'success'])->name('success');
                            Route::post('/checkout', [PackagesStripeWebhookController::class, 'checkout'])->name('action');
                        });

                        Route::group(['prefix' => 'mercado-pago', 'as' => 'mercado-pago.'], function () {
                            Route::group(['prefix' => 'pix', 'as' => 'pix.'], function () {
                                // Route::get('/success', [MercadoPagoWebhookController::class, 'success'])->name('success');
                                // Route::post('/notify', [MercadoPagoWebhookController::class, 'notify'])->name('notify');
                                Route::post('/checkout', [PackagesMercadoPagoWebhookController::class, 'checkout'])->name('action');
                            });
                        });
                        
                        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
                            Route::post('/cancel', [StoreController::class, 'cancel'])->name('cancel');
                        });
                    });
                    
                });

                Route::post('/', [StoreController::class, 'action'])->name('action');
                Route::get('/list', [StoreController::class, 'list'])->name('list');
                Route::post('/confirm', [StoreController::class, 'confirm'])->name('confirm');
                Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
                    Route::post('/', [StoreController::class, 'prepare'])->name('prepare');
                });

                Route::group(['prefix' => 'payment-method', 'as' => 'payment-method.'], function () {

                    Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
                        Route::get('/success', [StripeWebhookController::class, 'success'])->name('success');
                        Route::post('/checkout', [StripeWebhookController::class, 'checkout'])->name('action');
                    });

                    Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
                        Route::get('/success', [PayPalWebhookController::class, 'success'])->name('success');
                        Route::post('/checkout', [PayPalWebhookController::class, 'checkout'])->name('action');
                    });

                    Route::group(['prefix' => 'tibia-coins', 'as' => 'tibia-coins.'], function () {
                        Route::post('/checkout', [TibiaCoinsController::class, 'checkout'])->name('action');
                    });

                    Route::group(['prefix' => 'medivia-coins', 'as' => 'medivia-coins.'], function () {
                        Route::post('/checkout', [MediviaCoinsController::class, 'checkout'])->name('action');
                    });

                    Route::group(['prefix' => 'mercado-pago', 'as' => 'mercado-pago.'], function () {
                        Route::group(['prefix' => 'pix', 'as' => 'pix.'], function () {
                            Route::get('/success', [MercadoPagoWebhookController::class, 'success'])->name('success');
                            Route::post('/notify', [MercadoPagoWebhookController::class, 'notify'])->name('notify');
                            Route::post('/checkout', [MercadoPagoWebhookController::class, 'checkout'])->name('action');
                        });
                    });
                    
                    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
                        Route::post('/cancel', [StoreController::class, 'cancel'])->name('cancel');
                    });
                });

            });
            
            Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
                Route::get('/', function () {
                    return redirect(route('account.index'));
                });
                Route::group(['prefix' => 'premium', 'as' => 'premium.'], function () {
                    Route::get('/{page?}', [AccountPremiumHistoryController::class, 'index'])->name('index');
                });
            });
        }

        Route::group(['prefix' => 'bazaar', 'as' => 'bazaar.'], function () {

            //Sell Character
            Route::get('/sell', function () {
                return app(BazaarController::class)->sell_characters("sell_characters");  
            })->name('sell_characters');
        
            Route::post('/check', function () {
                return app(BazaarController::class)->sell_characters("check_characters");
            })->name('check_characters.post');

            Route::post('/auction', function () {
                return app(BazaarController::class)->sell_characters("auction_characters");
            })->name('auction_characters.post');

            Route::post('/confirm', function () {
                return app(BazaarController::class)->sell_characters("auction_confirm");
            })->name('auction_confirm.post');

            //My Auctions
            Route::get('/myAuctions', function () {
                return app(BazaarController::class)->auctions();  
            })->name('myAuctions');

            Route::post('/myAuctions', function () {
                return app(BazaarController::class)->auctions();  
            })->name('myAuctions.post');

            //bid Auctions
            Route::get('/currentAuctions', function () {
                return app(BazaarController::class)->currentAuctions();  
            })->name('currentAuctions');

            Route::post('/bidAuction', function() {
                return app(BazaarController::class)->currentAuctions();  
            })->name('bidAuction');

            Route::post('/finishBid', function() {
                return app(BazaarController::class)->currentAuctions();  
            })->name('finishBid');

            Route::post('/status', function() {
                return app(BazaarController::class)->currentAuctions();  
            })->name('statusAuction');

            //Finish Orders
            Route::post('/orders', function() {
                return app(BazaarController::class)->completeOrders();  
            })->name('bazaarOrders');

            //History
            Route::get('/history', function() {
                return app(BazaarController::class)->auction_history();  
            })->name('history');
        });
        
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => ['role:admin']], function () {

        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

            Route::get('/', [DashboardController::class, 'index'])->name('index');

            Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
                Route::get('/', [AdminNewsController::class, 'index'])->name('index');
                Route::post('/list/{id}', [AdminNewsController::class, 'list'])->name('list');
                Route::group(['prefix' => 'add', 'as' => 'add.'], function () {
                    Route::get('/', [AdminNewsController::class, 'add'])->name('index');
                    Route::post('/', [AdminNewsController::class, 'store'])->name('action');
                });
                Route::group(['prefix' => 'update', 'as' => 'update.'], function () {
                    Route::get('/{id}', [AdminNewsController::class, 'edit'])->name('index');
                    Route::post('/{id}', [AdminNewsController::class, 'update'])->name('action');
                });
                Route::post('/delete/{id}', [AdminNewsController::class, 'delete'])->name('delete');
            });

            Route::group(['prefix' => 'sprite-hd', 'as' => 'spriteHD.'], function () {
                Route::get('/', [AdminSpriteHDController::class, 'index'])->name('index');
                Route::post('/convert', [AdminSpriteHDController::class, 'convert'])->name('convert');
                Route::post('/process', [AdminSpriteHDController::class, 'process'])->name('process'); // Nova rota para conversão
                Route::get('/storage-data', [AdminSpriteHDController::class, 'storageData'])->name('storageData');
            });
            

            Route::group(['prefix' => 'vipDays', 'as' => 'vipDays.'], function () {
                Route::get('/', function () {
                    return view('admin.vip.index');
                })->name('index');
            });

            Route::get('/time-clock/code', [TimeClockController::class, 'showCodeForm'])->name('timeClock.showCodeForm');
            Route::post('/time-clock/form', [TimeClockController::class, 'showTimeForm'])->name('timeClock.showForm');
            Route::get('/time-clock/{employeeName}', [TimeClockController::class, 'index'])->name('timeClock.index');
            Route::post('/time-clock/store', [TimeClockController::class, 'store'])->name('timeClock.store');
            Route::post('/time-clock/update-status', [TimeClockController::class, 'updateStatus'])->name('timeClock.updateStatus');
            Route::get('/timeClock/luan', [TimeClockController::class, 'luanPage'])->name('timeClock.luanPage');
            Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
            Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
            Route::post('/employee/storePayment', [EmployeeController::class, 'storePayment'])->name('employee.payment');

            Route::group(['prefix' => 'bazaar', 'as' => 'bazaar.'], function () {
                Route::get('/', [\App\Http\Controllers\Admin\BazaarController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'shopGame', 'as' => 'shopGame.'], function () {
                Route::get('/', [\App\Http\Controllers\Admin\ShopGameController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'streamerReferences', 'as' => 'streamerReferences.'], function () {
                Route::get('/contracted', [StreamerReferencesController::class, 'index'])->name('contracted');
                Route::get('/all', [StreamerReferencesController::class, 'all'])->name('all');

                Route::post('/', [StreamerReferencesController::class, 'addStreamerReference'])->name('store'); // note o / vazio aqui
                Route::delete('/{id}', [StreamerReferencesController::class, 'removeStreamerReferenceById'])->name('destroy');
                Route::get('/get-updated-data', [StreamerReferencesController::class, 'getUpdatedStreamerReferences'])->name('get-updated-data');
                Route::get('/twitch/live-times', [TwitchLiveController::class, 'liveTimes'])->name('live-times');
            });


            Route::post('/streamer-references/update-status', [StreamerReferencesController::class, 'updateStatus'])->name('streamer-references.update-status');
            Route::get('/streamer-references/get-updated-data', [StreamerReferencesController::class, 'getUpdatedData'])->name('get-updated-data');
            Route::get('/get-updated-data', [StreamerReferencesController::class, 'getUpdatedData'])->name('get-updated-data');
            Route::post('/streamer-references/submit-multiple', [StreamerReferencesController::class, 'submitAllReferences']);
            Route::post('/streamers/store', [StreamerReferencesController::class, 'store'])->name('streamers.store');
            Route::delete('/streamers/delete/{id}', [StreamerReferencesController::class, 'destroy'])->name('streamers.destroy');
            Route::post('/streamers/approve/coupon/{id}', [StreamerReferencesController::class, 'approveCoupon'])->name('streamers.approveCoupon');
            Route::post('/streamers/reject/coupon/{id}', [StreamerReferencesController::class, 'rejectCoupon'])->name('streamers.rejectCoupon');
            Route::post('/streamers/approve/pix/{id}', [StreamerReferencesController::class, 'approvePix'])->name('streamers.approvePix');
            Route::post('/streamers/reject/pix/{id}', [StreamerReferencesController::class, 'rejectPix'])->name('streamers.rejectPix');
            Route::post('/streamers/updateDiscount', [StreamerReferencesController::class, 'updateCouponDiscount'])->name('streamers.updateDiscount');
            Route::get('/streamers/getCurrentDiscount', [StreamerReferencesController::class, 'getCurrentDiscount'])->name('streamers.getCurrentDiscount');


            Route::get('/duplicate-accounts/search', [PlayerController::class, 'searchDuplicateAccounts'])->name('duplicate-accounts.search');
            Route::get('/duplicate-accounts', [PlayerController::class, 'showDuplicateAccounts'])->name('duplicate-accounts');

            Route::group(['prefix' => 'houses', 'as' => 'houses.'], function () {
                Route::get('/', [HousesController::class, 'index'])->name('index');
                Route::post('/', [HousesController::class, 'create'])->name('action');
            });

            Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
                Route::get('/', [LogViewerController::class, 'index'])->name('dashboard');
                Route::get('list', [LogViewerController::class, 'listLogs'])->name('list');
                Route::delete('delete', [LogViewerController::class, 'delete'])->name('delete');
                Route::get('show/{date}', [LogViewerController::class, 'show'])->name('show');
                Route::get('download/{date}', [LogViewerController::class, 'download'])->name('download');
                Route::get('show/{date}/{level}', [LogViewerController::class, 'showByLevel'])->name('filter');
                Route::get('show/{date}/{level}/search', [LogViewerController::class, 'search'])->name('search');
            });

            Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
                Route::group(['prefix' => 'tibia-coins', 'as' => 'tibia-coins.'], function () {
                    Route::get('/', [TcTransactionsController::class, 'index'])->name('index');
                    Route::post('/action', [TcTransactionsController::class, 'action'])->name('action');
                    Route::post('/', [TcTransactionsController::class, 'list'])->name('list');
                });
                Route::group(['prefix' => 'medivia-coins', 'as' => 'medivia-coins.'], function () {
                    Route::get('/', [McTransactionsController::class, 'index'])->name('index');
                    Route::post('/action', [McTransactionsController::class, 'action'])->name('action');
                    Route::post('/', [McTransactionsController::class, 'list'])->name('list');
                });
            });

            Route::group(['prefix' => 'store', 'as' => 'store.'], function () {
                Route::group(['prefix' => 'payment-options', 'as' => 'payment-options.'], function () {
                    Route::get('/', [PaymentOptionsController::class, 'index'])->name('index');
                });
                Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
                    Route::get('/', [ProductsController::class, 'index'])->name('index');
                    Route::post('/', [ProductsController::class, 'list'])->name('list');
                    Route::post('/add', [ProductsController::class, 'store'])->name('store');
                    Route::post('/update', [ProductsController::class, 'update'])->name('update');
                    Route::post('/info', [ProductsController::class, 'info'])->name('info');
                });
            });

            Route::group(['prefix' => 'server-manager', 'as' => 'server-manager.'], function () {
                Route::get('/', function () {
                    return view('admin.server-manager.index');
                })->name('index');
            });

            Route::group(['prefix' => 'client-update', 'as' => 'client-update.'], function () {
                Route::get('/', [ClientUpdateController::class, 'index'])->name('index');
                Route::post('/', [ClientUpdateController::class, 'action'])->name('action');
            });

            Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
                Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
                    Route::get('/', [SearchPaymentController::class, 'searchView'])->name('searchView');
                    Route::post('/', [SearchPaymentController::class, 'searchPost'])->name('searchPost');
                    Route::group(['prefix' => '{emailAddress}', 'middleware' => ['orderHistoryEmail']], function () {
                        Route::get('/', [SearchPaymentController::class, 'search'])->name('search');
                    });
                });
            });
        });
    });
});

Route::any('{query}', function () {
    return redirect(route('landing'));
})->where('query', '.*');


