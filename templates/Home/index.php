<?php
/**
 * @var App\View\AppView $this
 * @var Cake\TwigView\View\TwigView $twig
 */

use Cake\Core\Configure;
use Cake\Utility\Inflector;

$baseUri = $this->getRequest()->getAttribute('base');
$this->set([
    'hasHeader' => false,
    'hasFooter' => false
]);

$this->setLayout('blank');

$siteBrand = Configure::read('Site.name');
?>
<section class="bg-yellow h-100 mgriukcz theme-color">
    <div id="starter" class="carousel h-100 pointer-event slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner h-100">
            <div id="welcome" class="carousel-item active h-100">
                <div class="p-6 text-center">
                    <h3>Welcome <br>To <?= $siteBrand ?></h3>
                    <p>Here you'll find millions of amazing <?= $siteBrand ?>s
                        just like you, make new connetions,
                        make deals and share wonderful moments together.</p>
                </div>
<!--                <footer class="fixed-bottom py-3">-->
<!--                    <div class="container-fluid">-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-pill btn-sm btn-white next-page text-right" href="#starter" role="button" data-slide="next">-->
<!--                                    <span class="mdi mdi-chevron-right mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Next</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </footer>-->
            </div>
            <div id="market-stuff" class="carousel-item h-100">
                <div class="p-6 text-center">
                    <h3>Market Your Entertainment</h3>
                    <p>Are you a recording artist, a song writer, a vocalist, a movie star or a comedian. Whatever
                        your role in entertainment industry is, we're sure you'll find a market or marketer to sell
                        your work.</p>
                </div>
<!--                <footer class="fixed-bottom py-3">-->
<!--                    <div class="container-fluid">-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-outline-light btn-pill btn-sm prev-page text-left" href="#starter" role="button" data-slide="prev">-->
<!--                                    <span class="mdi mdi-chevron-left mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Previous</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-pill btn-sm btn-white next-page text-right" href="#starter" role="button" data-slide="next">-->
<!--                                    <span class="mdi mdi-chevron-right mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Next</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </footer>-->
            </div>
            <div id="make-some-noise" class="carousel-item h-100">
                <div class="p-6 text-center">
                    <h3>Make Some Noise, Somebody!</h3>
                    <p>Shout-Out to your fans in gratitude or let them know about
                        your new song, movie or whatever; go live and share
                        your moment. All at your fingertip...</p>
                </div>
<!--                <footer class="fixed-bottom py-3">-->
<!--                    <div class="container-fluid">-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-outline-light btn-pill btn-sm prev-page text-left" href="#starter" role="button" data-slide="prev">-->
<!--                                    <span class="mdi mdi-chevron-left mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Previous</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-pill btn-sm btn-white next-page text-right" href="#starter" role="button" data-slide="next">-->
<!--                                    <span class="mdi mdi-chevron-right mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Next</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </footer>-->
            </div>
            <div id="find-stuff" class="carousel-item h-100">
                <div class="p-6 text-center">
                    <h3>Discover <?= $siteBrand ?>s</h3>
                    <p>Discover what's new; discover upcoming & promising artists to invest in, fellow TV
                        personalities; follow your interests.</p>
                </div>
<!--                <footer class="fixed-bottom py-3">-->
<!--                    <div class="container-fluid">-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-outline-light btn-pill btn-sm prev-page text-left" href="#starter" role="button" data-slide="prev">-->
<!--                                    <span class="mdi mdi-chevron-left mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="sr-only">Previous</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-pill btn-sm btn-white next-page text-right" href="#starter" role="button" data-slide="next">-->
<!--                                    <span class="mdi mdi-chevron-right mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="btn-text">Sign Up</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </footer>-->
            </div>
            <div id="signup" class="carousel-item h-100">
                <div class="px-4 py-6 text-center">
                    <?= $this->element('Auth/signup'); ?>
                </div>
<!--                <footer class="fixed-bottom py-3">-->
<!--                    <div class="container-fluid">-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <a class="btn btn-block btn-outline-light btn-pill btn-sm prev-page text-left" href="#starter" role="button" data-slide="prev">-->
<!--                                    <span class="mdi mdi-chevron-left mdi-24px" aria-hidden="true"></span>-->
<!--                                    <span class="btn-text">Cancel</span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </footer>-->
            </div>
        </div>
    </div>
    <nav class="fixed-bottom py-3">
        <div class="container-fluid">
            <div class="row gutters-sm">
                <div class="col">
                    <a class="btn btn-block btn-outline-light btn-pill btn-sm prev-page text-left" href="#starter" role="button" data-slide="prev">
                        <span class="mdi mdi-chevron-left mdi-24px" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                </div>
                <div class="col">
                    <a class="btn btn-block btn-pill btn-sm btn-white bzakvszf n1ft4jmn next-page qrfe0hvl text-right" href="#starter" role="button" data-slide="next">
                        <span class="btn-text sr-only">Sign Up</span>
                        <span class="mdi mdi-chevron-right mdi-24px ml-auto" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</section>



