# AI Copilot Instructions for YV-LMS

YV-LMS is a comprehensive **Laravel 9 Learning Management System** with multi-user roles (admin, instructor, student, organization), course management, payments, consultations, and AI features.

## Architecture Overview

### Core Structure
- **Framework**: Laravel 9 + Eloquent ORM, Laravel Passport (API auth), Spatie Permissions
- **Frontend**: Vue 2.6, Bootstrap 5, Laravel Mix, with multiple themes (`frontend`, `frontend-theme-2/3`)
- **Key Models**: `User`, `Course`, `Enrollment`, `Order`, `Payment`, `Instructor`, `Organization`, `Bundle`, `Package`

### Route Organization (Multi-Role System)
Routes are segmented by user role in `routes/` with shared middleware:
- **`frontend.php`**: Public course browsing, authentication
- **`admin.php`**: System administration (prefix: `/admin`)
- **`instructor.php`**: Course creation/management (prefix: `/instructor`)
- **`student.php`**: Enrollment, learning (prefix: `/student`, includes device tracking)
- **`organization.php`**: Organization management (prefix: `/organization`)
- **`common.php`**: Shared features (wallets, notifications, tickets)
- **`api.php`**: REST API endpoints

Each route group uses role-based middleware: `admin`, `instructor`, `student`, `organization` check user roles via `User::role` (1=admin).

### Key Middleware
- `LocalizationMiddleware`: Handles multi-language support (`resources/lang/`)
- `CourseAccessMiddleware`: Validates student enrollment before accessing course content
- `DeviceControlMiddleware`: Tracks login devices via `ivanomatteo/laravel-device-tracking`
- `VersionUpdate`: Application version management
- `AddonMiddleware`: Validates installed addons (modular extensibility)

## Payment System Architecture

**Multi-Gateway Integration** (Omnipay library):
- **Supported Gateways**: Razorpay, PayPal, Stripe, Mollie, MercadoPago, Iyzipay, OpenPay, Braintree, BitPay, Paystack, SSL Commerz
- **Key Flow**:
  1. Cart → `CartManagement` model stores course/product/consultation selections
  2. Checkout → `Order` + `Order_item` records created
  3. Payment → `PaymentApiController::paymentNotifier()` processes callback
  4. Completion → `distributeCommission()` helper handles affiliate/subscription revenue

**Payment Models**:
- `Order`: Master transaction record (`payment_status`: 'due'/'paid', `payment_method` stores gateway name)
- `Payment`: Alternate payment recording table (for manual deposits, bank transfers)
- `CartManagement`: Transient cart state with course/consultation details
- `WalletRecharge`: User wallet top-ups

**Custom Helpers** in `app/Helper/helper.php`:
- `getPaymentMethodId()`: Maps gateway names to IDs
- `distributeCommission()`: Processes affiliate payouts, subscription commissions, instructor revenue

## Domain Knowledge

### Course & Learning Structure
- **Hierarchical**: Category → Subcategory → Course
- **Content Types**:
  - **Lectures** (`Course_lecture`): Supports YouTube, Vimeo, uploaded video, SCORM packages
  - **Lessons** (`Course_lesson`): Organize lectures with drip-content support
  - **Exams** (`Exam`, `Question`, `Take_exam`, `Answer`): Auto-graded assessments
  - **Assignments** (`Assignment`, `AssignmentSubmit`): File-based submission tracking

- **Enrollment Model** (`Enrollment`):
  - Links student to course/bundle/package/consultation
  - Tracks progress (`progress` field), completion, certificates
  - Supports multiple enrollment types: courses, bundles, packages, consultations

- **SCORM** (`devianl2/laravel-scorm`): 
  - Stored in `public/scorm/`
  - Tracked via `Course_lecture` + `Enrollment` + `Course_lecture_views` join

### Subscription & Packages
- **Packages** (`Package`, `UserPackage`): Recurring billing (monthly/annual)
- **Bundles** (`Bundle`, `BundleCourse`): Grouped courses sold together
- **Commission Distribution**: 
  - Instructor revenue calculated on course sales
  - Affiliate commissions tracked in `AffiliateHistory`
  - Monthly distribution via `MonthlyDistributionHistory`

### Consultations & Live Sessions
- **Instructor Consultations**: `InstructorConsultationDayStatus`, `ConsultationSlot`, `BookingHistory`
- **Live Classes**: `LiveClass` (BigBlueButton integration via `joisarjignesh/bigbluebutton`)
- **Zoom**: `ZoomSetting`, `GmeetSetting` for video conferencing

### Multi-Tenancy
- **Organization Model**: Instructors/courses can belong to organizations
- **Schema**: Add `organization_id` FK to courses, instructors, students
- **Isolation**: Enforced via query scopes and middleware checks

## Developer Workflows

### Local Setup
```bash
php artisan serve                    # Start dev server (port 8000)
npm run dev                          # Watch assets (Vue/SASS compilation)
php artisan migrate --seed           # Run migrations + seeders
php artisan tinker                   # Interactive shell
```

### Database & Migrations
- **Location**: `database/migrations/` (150+ migrations, scoped by feature)
- **Seeding**: `database/seeders/` for initial data
- **Patterns**: Use soft deletes (`SoftDeletes` trait) for users, orders
- **Running**: `php artisan migrate:refresh --seed` (dev only)

### Testing
- **Config**: `phpunit.xml` defines Unit + Feature suites
- **Location**: `tests/Unit/`, `tests/Feature/`
- **Run**: `./vendor/bin/phpunit` or `php artisan test`
- **Database**: Tests use array cache, array mail driver (no real emails)

### Code Patterns & Conventions

**Model Traits** (commonly used):
- `HasFactory`: Factory-based seeding
- `SoftDeletes`: Logical delete with `deleted_at` timestamp
- `HasRoles`: Spatie permissions (admin, instructor, student, organization roles)
- `UseDevices`: Device tracking for security
- `HasApiTokens`: Passport OAuth tokens

**Eloquent Relationships** (common pattern):
```php
// Course → Instructor/User (multiple instructors via CourseInstructor pivot)
$course->course_instructors()->attach($instructor_id);

// Order → Items (one-to-many with course/product/consultation details)
$order->items()->get();  // Polymorphic-like via `course_id`, `product_id`, `bundle_id`

// Enrollment tracking (unifies course, bundle, package, consultation)
$student->enrollments()->where('course_id', $id)->first();
```

**Helper Functions** (in `app/Helper/helper.php` - 1300+ lines):
- `get_option($key)`: Config-driven settings (case-insensitive lookup)
- `getImageFile()`, `getVideoFile()`: Storage paths with public URLs
- `toastrMessage()`: Toast notifications (Vue integration)
- `isAddonInstalled($addon)`: Checks addon state for conditional features

**Payment Method Constants** (used throughout):
```php
MERCADOPAGO, PAYPAL, RAZORPAY, STRIPE, IYZIPAY, OPENPAY, BRAINTREE, BITPAY, PAYSTACK, SSL_COMMERZ
```

**Order Status Constants**:
```php
ORDER_PAYMENT_STATUS_DUE = 'due', 'paid', 'failed', 'refunded'
```

### Addon System
- Modular extensions loaded via `AddonMiddleware`
- Check with `isAddonInstalled()` before accessing features (e.g., `LMSZAIAI` for AI)
- Migrations/models placed in `app/Models/Addon/{AddonName}/`

### Asset Management (Laravel Mix)
- **CSS**: `resources/css/` + `resources/sass/` → compiled to `public/css/`
- **JS**: `resources/js/` + Vue components → `public/js/app.js`
- **Command**: `npm run production` for minified build

## External Integrations

### Payment Gateways
- See `config/paypal.php`, `config/paystack.php`, `config/sslcommerz.php`
- Gateway selection in checkout: `BasePaymentService` class handles abstraction
- BitPay keys stored in `config/laravel-bitpay.php` (encrypted filesystem storage)

### Communication
- **Email**: Laravel Mail with `Email_template` model for custom templates
- **SMS**: Integrated (check `config/services.php`)
- **Notifications**: `Notification` model + Laravel notifications

### Content & Learning
- **Google Calendar**: `config/google-calendar.php` for event scheduling
- **BigBlueButton**: `config/bigbluebutton.php` for live classes
- **Zoom**: Zoom API via `jubaer/zoom-laravel` package
- **Newsletter**: Mailchimp API via `Spatie\Newsletter`, config: `config/newsletter.php`
- **AI**: OpenAI API (`orhanerday/open-ai`) for content generation

### File Storage
- **Local**: `public/uploads/`, `public/scorm/`, `public/frontend/`
- **S3**: AWS S3 integration via `league/flysystem-aws-s3-v3`, separate S3 buckets for SCORM
- **Config**: `config/filesystems.php` defines `scorm-local`, `s3-scorm` disks

## Common Tasks & Patterns

### Adding a Payment Gateway
1. Install Omnipay provider package (e.g., `omnipay/stripe`)
2. Create payment processor in `app/Http/Services/Payment/`
3. Map gateway constant to processor in `BasePaymentService`
4. Update payment method selection UI in checkout views

### Creating a New Admin Feature
1. Create controller: `app/Http/Controllers/Admin/{Feature}Controller.php`
2. Register routes in `routes/admin.php`
3. Add permission via `spatie/laravel-permission`
4. Create views in `resources/views/admin/{feature}/`

### Handling Multi-Language
- Language files in `resources/lang/{locale}/`
- Use `__('key')` helper in PHP/Blade
- `LocalizationMiddleware` sets locale from URL prefix or user preference

### User Roles & Permissions
- Roles stored in database (Spatie)
- Check in middleware: `middleware('admin')` redirects non-admin users
- Check in code: `auth()->user()->hasRole('instructor')`
- Assign via: `$user->assignRole('instructor')`

## Critical Files Reference

| File | Purpose |
|------|---------|
| [app/Models/User.php](app/Models/User.php) | User model, roles, relationships |
| [app/Models/Course.php](app/Models/Course.php) | Course model, content hierarchy |
| [app/Models/Order.php](app/Models/Order.php) | Order/transaction records |
| [app/Helper/helper.php](app/Helper/helper.php) | 1300+ global helpers |
| [routes/web.php](routes/web.php), [routes/api.php](routes/api.php) | Route definitions |
| [config/app.php](config/app.php) | App configuration |
| [database/migrations/](database/migrations/) | Schema definitions |
| [app/Http/Services/Payment/](app/Http/Services/Payment/) | Payment gateway abstraction |

---

**Last Updated**: January 17, 2026
