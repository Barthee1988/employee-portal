<?php
// app/Services/Notifier.php
namespace App\Services;

class Notifier {
  public static function send(string $to, string $message): void {
    // Placeholder: send email or in-app notification
    error_log("Notify $to: $message");
  }
}
