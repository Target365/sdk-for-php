<?php

declare(strict_types=1);

namespace Target365\ApiSdk\Model;

abstract class DetailedStatusCodes
{
    public const NONE                      = 'None';
    public const DELIVERED                 = 'Delivered';
    public const EXPIRED                   = 'Expired';
    public const UNDELIVERED               = 'Undelivered';
    public const UNKNOWN_ERROR             = 'UnknownError';
    public const OTHER_ERROR               = 'OtherError';
    public const REJECTED                  = 'Rejected';
    public const UNKNOWN_SUBSCRIBER        = 'UnknownSubscriber';
    public const SUBSCRIBER_UNAVAILABLE    = 'SubscriberUnavailable';
    public const SUBSCRIBER_BARRED         = 'SubscriberBarred';
    public const INSUFFICIENT_FUNDS        = 'InsufficientFunds';
    public const REGISTRATION_REQUIRED     = 'RegistrationRequired';
    public const UNKNOWN_AGE               = 'UnknownAge';
    public const DUPLICATE_TRANSACTION     = 'DuplicateTransaction';
    public const SUBSCRIBER_LIMIT_EXCEEDED = 'SubscriberLimitExceeded';
    public const MAX_PIN_RETRY             = 'MaxPinRetry';
    public const INVALID_AMOUNT            = 'InvalidAmount';
    public const ONE_TIME_PASSWORD_EXPIRED = 'OneTimePasswordExpired';
    public const ONE_TIME_PASSWORD_FAILED  = 'OneTimePasswordFailed';
    public const SUBSCRIBER_TOO_YOUNG      = 'SubscriberTooYoung';
    public const TIMEOUT_ERROR             = "TimeoutError";
    public const PENDING                   = "Pending";
    public const TEMPORARY_ERROR           = "TemporaryError";
    public const MISSING_PREAUTH           = "MissingPreAuth";
    public const MISSING_DELIVERY_REPORT   = "MissingDeliveryReport";
    public const USER_IN_TRANSACTION       = "UserInTransaction";
    public const CONNECTION_OFFLINE        = "ConnectionOffline";
    public const INVALID_CREDENTIALS       = "InvalidCredentials";
    public const INVALID_OTP               = "InvalidOtp";
    public const CARD_PSP_ERROR            = "CardPspError";
    public const MNO_ERROR                 = "MnoError";
}
