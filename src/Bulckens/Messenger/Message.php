<?php

namespace Bulckens\Messenger;

use Bulckens\Helpers\FileHelper;
use Bulckens\AppTools\App;
use Bulckens\AppTools\Traits\Configurable;

class Message {

  use Configurable;

  protected $message;
  protected $title;
  protected $icon;
  protected $link;
  protected $root;
  protected $os;

  public function __construct( $message, $file = 'messenger.yml' ) {
    // define custom config file
    $this->configFile( $file );

    // store os
    if ( `which sw_vers` ) {
      $this->os = 'macOS';
    } elseif ( `which lscpu` ) {
      $this->os = 'linux';
    } else {
      $this->os = 'other';
    }

    // set root
    $this->root = FileHelper::parent( __DIR__, 3 );

    // store message
    $this->message = addslashes( $message );

    // set configured or default title
    $this->title( $this->config( 'title', 'Message' ) );

    // set configured icon
    $this->icon( $this->config( 'icon' ) );
  }


  // Get full notifier path
  public function notifier() {
    switch ( $this->os ) {
      case 'macOS':
        return "$this->root/utilities/terminal-notifier.app/Contents/MacOS/terminal-notifier";
      break;
      case 'linux':
        return 'notify-send';
      break;
    }
  }


  // Set title
  public function title( $title ) {
    $this->title = addslashes( $title );
    return $this;
  }


  // Set icon
  public function icon( $icon ) {
    $this->icon = App::root( $icon );
    return $this;
  }


  // Set link
  public function link( $link ) {
    $this->link = $link;
    return $this;
  }


  // Build command
  public function command() {
    // prepare command
    switch ( $this->os ) {
      case 'macOS':
        $command = [
          "-message '$this->message'"
        , "-title '$this->title'"
        , ( is_file( $this->icon ) ? "-appIcon '$this->icon'" : '' )
        , ( $this->link ? "-open '$this->link'" : '')
        ];
      break;
      case 'linux':
        $command = [
          "'$this->title'"
        , "'$this->message'"
        , "-t 500"
        , ( is_file( $this->icon ) ? "-i '$this->icon'" : '' )
        ];
      break;
    }

    // build full command
    if ( isset( $command )) {
      return $this->notifier() . ' ' . implode( ' ', $command );
    }
  }


  // Show notifier
  public function run() {
    return exec( $this->command());
  }

}
