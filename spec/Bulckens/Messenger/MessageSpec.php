<?php

namespace spec\Bulckens\Messenger;

use Bulckens\AppTools\App;
use Bulckens\Messenger\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior {

  function let() {
    new App( 'dev', __DIR__, 3 );
    $this->beConstructedWith( 'Hellø' );
  }

  // Initialization
  function it_sets_the_message() {
    $this->beConstructedWith( 'Más adelante' );
    $this->command()->shouldMatch( "/( -message)? 'Más adelante'/" );
  }


  // Notifier method
  function it_gets_the_full_notifier_path() {
    $this->notifier()->shouldMatch( '/notify-send|terminal-notifier/' );
  }


  // Title method
  function it_sets_the_title() {
    $this->title( 'Cuidado' );
    $this->command()->shouldMatch( "/( -title)? 'Cuidado'/" );
  }

  function it_uses_a_configured_title() {
    $this->command()->shouldMatch( "/( -title)? 'Messenger'/" );
  }

  function it_uses_a_default_title_when_none_is_given_or_configured() {
    $this->beConstructedWith( 'Más adelante', 'empty.yml' );
    $this->command()->shouldMatch( "/( -title)? 'Message'/" );
  }

  function it_returns_itself_after_setting_the_title() {
    $this->title( '¡Mastaba!' )->shouldBe( $this );
  }


  // Icon method
  function it_sets_the_icon() {
    $this->icon( 'dev/images/some-ugly-shit.png' );
    $this->command()->shouldContain( "/some-ugly-shit.png'" );
  }

  function it_uses_no_icon_when_none_is_given() {
    $this->beConstructedWith( 'Iconless', 'empty.yml' );
    $this->command()->shouldNotContain( '-appIcon' );
  }

  function it_returns_itself_after_setting_the_icon() {
    $this->icon( 'some-ugly-shit.png' )->shouldBe( $this );
  }


  // Link method (not cross platform)
  // function it_sets_the_link() {
  //   $this->link( 'http://somewhere.else' );
  //   $this->command()->shouldContain( "-open 'http://somewhere.else'" );
  // }
  //
  // function it_uses_no_link_when_none_is_given() {
  //   $this->command()->shouldNotContain( '-open' );
  // }
  //
  // function it_returns_itself_after_setting_the_link() {
  //   $this->link( 'http://somewhere.else' )->shouldBe( $this );
  // }


  // Command method
  function it_retuns_the_command() {
    $this->beConstructedWith( 'Más adelante' );
    $this->title( 'Beast' );
    $this->command()->shouldMatch( '/notify-send|terminal-notifier/' );
    $this->command()->shouldMatch( '/(-title )? \'Beast\' /' );
    $this->command()->shouldMatch( '/(-message )? \'Más adelante\' /' );
  }


  // Run method
  function it_returns_itself_after_showing_the_notification() {
    $this->run()->shouldBe( '' );
  }


  // Visual tests
  function it_shows_a_custom_title_and_icon() {
    $this->beConstructedWith( 'Custom message' );
    $this->icon( 'dev/images/some-ugly-shit.png' );
    $this->title( 'Custom title' )->run();
  }

  function it_shows_no_icon() {
    $this->beConstructedWith( 'No second icon is showing', 'empty.yml' );
    $this->title( 'Iconless' )->run();
  }

  function it_shows_a_link() {
    $this->beConstructedWith( 'Linking is fun!' );
    $this->link( 'http://somewhere.else' );
    $this->title( 'Linked' )->run();
  }


}
