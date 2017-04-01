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
    $this->command()->shouldContain( " -message 'Más adelante'" );
  }

  function it_adds_slashes_when_the_given_message_contains_single_quotes() {
    $this->beConstructedWith( "It's fabulous" );
    $this->command()->shouldContain( " -message 'It\'s fabulous'" );
  }

  function it_adds_slashes_when_the_given_message_contains_double_quotes() {
    $this->beConstructedWith( 'A weird "banana" they said' );
    $this->command()->shouldContain( " -message 'A weird \\\"banana\\\" they said'" );
  }
  
  
  // Notifier method
  function it_gets_the_full_notifier_path() {
    $this->notifier()->shouldEndWith( 'utilities/terminal-notifier.app/Contents/MacOS/terminal-notifier' );
  }


  // Title method
  function it_sets_the_title() {
    $this->title( 'Cuidado' );
    $this->command()->shouldContain( " -title 'Cuidado'" );
  }

  function it_uses_a_configured_title() {
    $this->command()->shouldContain( " -title 'Messenger'" );
  }

  function it_uses_a_default_title_when_none_is_given_or_configured() {
    $this->beConstructedWith( 'Más adelante', 'empty.yml' );
    $this->command()->shouldContain( " -title 'Message'" );
  }

  function it_adds_slashes_when_the_given_title_contains_single_quotes() {
    $this->title( "They're gone" );
    $this->command()->shouldContain( " -title 'They\'re gone'" );
  }

  function it_adds_slashes_when_the_given_title_contains_double_quotes() {
    $this->title( 'The "nice" leg...' );
    $this->command()->shouldContain( " -title 'The \\\"nice\\\" leg...'" );
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


  // Command method
  function it_retuns_the_command() {
    $this->command()->shouldContain( 'utilities/terminal-notifier.app/Contents/MacOS/terminal-notifier' );
    $this->command()->shouldContain( '-appIcon ' );
    $this->command()->shouldContain( '-title ' );
    $this->command()->shouldContain( '-message ' );
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

}
