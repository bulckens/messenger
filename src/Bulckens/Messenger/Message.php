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

  public function __construct( $message, $file = 'messenger.yml' ) {
    // define custom config file
    $this->file( $file );

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
    return "$this->root/utilities/terminal-notifier.app/Contents/MacOS/terminal-notifier";
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
    $command = [
      "-message '$this->message'"
    , "-title '$this->title'"
    ];

    // add icon
    if ( is_file( $this->icon ) )
      array_push( $command, "-appIcon '$this->icon'" );

    // add link
    if ( $this->link )
      array_push( $command, "-open '$this->link'" );

    // build full command
    return $this->notifier() . ' ' . implode( ' ', $command );
  }


  // Show notifier
  public function run() {
    return exec( $this->command() );
  }

}
