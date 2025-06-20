<?php


// User Role Type
const USER_ROLE_ADMIN = 1;
const USER_ROLE_INSTRUCTOR = 2;
const USER_ROLE_STUDENT = 3;
const USER_ROLE_ORGANIZATION = 4;



// Status
const STATUS_PENDING = 0;
const STATUS_ACCEPTED = 1;
const STATUS_SUCCESS = 1;
const STATUS_APPROVED = 1;
const STATUS_REJECTED = 2;
const STATUS_HOLD = 3;
const STATUS_SUSPENDED = 4;
const STATUS_DELETED = 5;
const STATUS_UPCOMING_REQUEST = 6;
const STATUS_UPCOMING_APPROVED = 7;

// withdrawal Status
const WITHDRAWAL_STATUS_PENDING = 0;
const WITHDRAWAL_STATUS_COMPLETE = 1;
const WITHDRAWAL_STATUS_REJECTED = 2;


// Status
const AFFILIATE_REQUEST_PENDING = 2;
const AFFILIATE_REQUEST_REJECTED = 3;
const AFFILIATOR = 1;
const NOT_AFFILIATOR = 0;

const AFFILIATE_HISTORY_STATUS_PAID = 1;
const AFFILIATE_HISTORY_STATUS_DUE = 0;

// Transaction type
const TRANSACTION_DEPOSIT = 1;
const TRANSACTION_WITHDRAWAL = 2;
const TRANSACTION_BUY = 3;
const TRANSACTION_SELL = 4;
const TRANSACTION_AFFILIATE = 5;
const TRANSACTION_WITHDRAWAL_CANCEL = 6;
const TRANSACTION_REFUND = 7;
const TRANSACTION_SUBSCRIPTION_BUY = 8;
const TRANSACTION_REGISTRATION_BONUS = 9;
const TRANSACTION_CASHBACK = 10;
const TRANSACTION_REWARD = 11;
const TRANSACTION_SELL_REFUND = 12;
const TRANSACTION_WALLET_RECHARGE = 13;

// narration
const DEPOSIT_NARRATION = '';
const WITHDRAWAL_NARRATION = '';
const BUY_NARRATION = '';
const SELL_NARRATION = '';
const AFFILIATE_NARRATION = 'Earning via affiliate';

//Order

const ORDER_PAYMENT_STATUS_PAID = 'paid';
const ORDER_PAYMENT_STATUS_DUE = 'due';
const ORDER_PAYMENT_STATUS_FREE = 'free';
const ORDER_PAYMENT_STATUS_PENDING = 'pending';
const ORDER_PAYMENT_STATUS_CANCELLED = 'cancelled';

//course type
const COURSE_TYPE_GENERAL = 1;
const COURSE_TYPE_SCORM = 2;
const COURSE_TYPE_LIVE_CLASS = 3;

const SEND_BACK_MONEY_STATUS_YES = 1;
const SEND_BACK_MONEY_STATUS_NO = 0;

//Booking History
const BOOKING_HISTORY_STATUS_PENDING = 0;
const BOOKING_HISTORY_STATUS_APPROVE = 1;
const BOOKING_HISTORY_STATUS_CANCELLED = 2;
const BOOKING_HISTORY_STATUS_COMPLETED = 3;

//drip content
const DRIP_SHOW_ALL = 1;
const DRIP_SEQUENCE = 2;
const DRIP_AFTER_DAY = 3;
const DRIP_UNLOCK_DATE = 4;
const DRIP_PRE_IDS = 5;

//course access period status
const ACCESS_PERIOD_ACTIVE = 1;
const ACCESS_PERIOD_DEACTIVATE = 0;

//max expired date
const MAX_EXPIRED_DATE = '2037-12-31 23:59:59';

//certificate status
const CERTIFICATE_DRAFT = 0;
const CERTIFICATE_VALID = 1;

//google meet
const GMEET_UNAUTHORIZE = 0;
const GMEET_AUTHORIZE = 1;

// package Type
const PACKAGE_TYPE_SUBSCRIPTION = 1;
const PACKAGE_TYPE_SAAS_INSTRUCTOR = 2;
const PACKAGE_TYPE_SAAS_ORGANIZATION = 3;

// package Status
const PACKAGE_STATUS_DISABLED = 0;
const PACKAGE_STATUS_ACTIVE = 1;
const PACKAGE_STATUS_CANCELED = 2;
const PACKAGE_STATUS_EXPIRED = 3;
const PACKAGE_STATUS_PENDING = 4;

// package rules
const PACKAGE_RULE_INSTRUCTOR = 1;
const PACKAGE_RULE_STUDENT = 2;
const PACKAGE_RULE_COURSE = 3;
const PACKAGE_RULE_BUNDLE_COURSE = 4;
const PACKAGE_RULE_SUBSCRIPTION_COURSE = 5;
const PACKAGE_RULE_CONSULTANCY = 6;
const PACKAGE_RULE_PRODUCT = 7;
const PACKAGE_RULE_DEVICE = 8;

//Subscription Type
const SUBSCRIPTION_TYPE_MONTHLY=1;
const SUBSCRIPTION_TYPE_YEARLY=2;

//Booking History
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const OPENPAY = 'openpay';
const BANK = 'bank';
const MOLLIE = 'mollie';
const COINBASE = 'coinbase';
const INSTAMOJO = 'instamojo';
const PAYSTAC = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const ZITOPAY = 'zitopay';
const IYZIPAY = 'iyzipay';
const BITPAY = 'bitpay';
const BRAINTREE = 'braintree';


const SWR = 'Something went wrong';

// ranking level
const RANKING_LEVEL_REGISTRATION = 1;
const RANKING_LEVEL_EARNING = 2;
const RANKING_LEVEL_COURSES_COUNT = 3;
const RANKING_LEVEL_STUDENTS_COUNT = 4;
const RANKING_LEVEL_COURSES_SALE_COUNT = 5;
const IN_CITY = 1;
const ALL_OVER_THE_COUNTRY = 2;
const ALL_OVER_THE_WORLD = 3;
const CONSULTANCY_AREA_ARRAY = [
    IN_CITY => 'In City',
    ALL_OVER_THE_COUNTRY => 'All Over The World',
    ALL_OVER_THE_WORLD => 'All Over The World',
];

const INSTRUCTOR_IS_OFFLINE = 1;
const INSTRUCTOR_CARD_TYPE_ONE = 1;
const INSTRUCTOR_CARD_TYPE_TWO = 2;
const INSTRUCTOR_CARD_TYPE_THREE = 3;

const COURSE_PRIVATE_DEACTIVATE = 0;
const COURSE_PRIVATE_ACTIVE = 1;

const BENEFICIARY_BANK = 1;
const BENEFICIARY_CARD = 2;
const BENEFICIARY_PAYPAL = 3;

//payment types

const PAYMENT_TYPE_SUBSCRIPTION=1;
const PAYMENT_TYPE_WALLET_RECHARGE=2;

const PHYSICAL_PRODUCT=1;
const DIGITAL_PRODUCT=2;

const THEME_DEFAULT = 1;
const THEME_TWO = 2;
const THEME_THREE = 3;