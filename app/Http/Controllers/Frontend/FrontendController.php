<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\FaqGenre;
use App\Enums\SEOPage;
use App\Enums\Status;
use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionLevel;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreSubscribeEmailRequest;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Seo;
use App\Models\SiteSettings;
use App\Models\SubscribeEmail;
use App\Models\SubscriptionPlan;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PolicySettings;
use App\Models\MeritResource;
use App\Models\PastPaper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    protected array $seoCore;

    public function home(): View
    {
        $subscriptionPricing = SubscriptionPlan::query()
            ->where('status', Status::ACTIVE->value)
            ->get()
            ->groupBy(function ($plan) {
                return strtolower(SubscriptionLevel::from($plan->level)->name);
            })
            ->map(function ($plansByLevel) {
                // Group each level into 2 types (e.g., School vs. Individual)
                return $plansByLevel->groupBy(function ($plan) {
                    return strtolower(SubscriptionType::from($plan->type)->name);
                })->map(function ($plansByType) {
                    return $plansByType->groupBy(function ($p) {
                        return strtolower(SubscriptionDuration::from($p->duration)->name);
                    });
                });
            });

        $products = Product::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $counter['past_papers'] = PastPaper::query()->count();
        $counter['resources'] = MeritResource::query()->count();
        $counter['users'] = User::query()->where('type', '!=', UserType::STUDENT->value)->count();
        $counter['students'] = User::query()->where('type', UserType::STUDENT->value)->count();


        $testimonials = Testimonial::query()->latest('created_at')->take(4)->get();

        $faqs = Faq::query()
            ->where('status', Status::ACTIVE->value)
            ->take(5)->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::HOME->value)
            ->first();

        return view('frontend.home.index-2')
            ->with([
                'defaultSEO' => $defaultSEO,
                'subscriptionPricing' => $subscriptionPricing,
                'products' => $products,
                'counter' => $counter,
                'testimonials' => $testimonials,
                'faqs' => $faqs,
            ]);
    }

    public function aboutUs(): View
    {
        $counter['past_papers'] = PastPaper::query()->count();
        $counter['resources'] = MeritResource::query()->count();
        $counter['users'] = User::query()->where('type', '!=', UserType::STUDENT->value)->count();
        $counter['students'] = User::query()->where('type', UserType::STUDENT->value)->count();

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::ABOUT_US->value)
            ->first();

        return view('frontend.about-us.index-2')->with([
            'defaultSEO' => $defaultSEO,
            'counter' => $counter,
            'testimonials' => $testimonials,
        ]);
    }

    public function contactUs(): View
    {
        $settings = SiteSettings::query()->first();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::CONTACT->value)
            ->first();

        return view('frontend.contact-us.index')
            ->with([
                'defaultSEO' => $defaultSEO,
                'settings' => $settings,
            ]);
    }

    public function contactUsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:25',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $insert = Contact::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        $message = [];

        if ($insert) {
            $message['status'] = 'success';
            $message['text'] = 'Thank you for contacting us';
        } else {
            $message['status'] = 'error';
            $message['text'] = 'There might be a error. Please try again later';
        }

        return to_route('contact-us')
            ->with($message['status'], $message['text']);
    }

    public function faq()
    {
        $faqs = Faq::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::FAQ->value)
            ->first();

        return view('frontend.faq.index-2')->with([
            'defaultSEO' => $defaultSEO,
            'FAQs' => $faqs,
            'testimonials' => $testimonials,
            'cases' => FaqGenre::cases(),
        ]);
    }

    public function privacyPolicy()
    {
        $privacyPolicy = PolicySettings::query()->where('key', 'Privacy Policy')->first();

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PRIVACY_POLICY->value)
            ->first();

        return view('frontend.privacy-policy.index-2')
            ->with([
                'defaultSEO' => $defaultSEO,
                'privacyPolicy' => $privacyPolicy->value ?? "",
                'testimonials' => $testimonials,
            ]);
    }

    public function refundPolicy()
    {
        $refundPolicy = PolicySettings::query()->where('key', 'Refund Policy')->first();

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::HOME->value)
            ->first();

        return view('frontend.refund-policy.index')
            ->with([
                'refundPolicy' => $refundPolicy->value ?? "",
                'testimonials' => $testimonials,
                'defaultSEO' => $defaultSEO,
            ]);
    }


    public function termsCondition(): View
    {
        $termsAndCondition = PolicySettings::query()->where('key', 'Terms & Conditions')->first();

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::TERMS_CONDITION->value)
            ->first();

        return view('frontend.terms-conditions.index-2')
            ->with([
                'defaultSEO' => $defaultSEO,
                'termsAndCondition' => $termsAndCondition->value ?? "",
                'testimonials' => $testimonials,
            ]);
    }

    public function collectEmails(StoreSubscribeEmailRequest $request)
    {
        SubscribeEmail::query()->create($request->all());

        // return to_route('home')
        //     ->with('success', 'Our offerings will now connect you seamlessly ..');
        return response()->json([
            'success' => true,
            'message' => 'Our offerings will now connect you seamlessly.'
        ], 200);
    }

    public function pricing(): View
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->type == UserType::TEACHER->value) {
                abort(403, 'Unauthorized action . ');
            }
        }

        $this->seoCore = [
            'title' => 'Pricing'
        ];

        $subscriptionPricing = SubscriptionPlan::query()
            ->where('status', Status::ACTIVE->value)
            ->get()
            ->groupBy(function ($plan) {
                return strtolower(SubscriptionType::from($plan->type)->name);
            });

        $testimonials = Testimonial::query()->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PRICING->value)
            ->first();

        return view('frontend.pricing.index')
            ->with([
                'defaultSEO' => $defaultSEO,
                'subscriptionPricing' => $subscriptionPricing,
                'testimonials' => $testimonials,
            ]);
    }

    public function findextention()
    {
        $path = public_path('uploads/pastpaper');

        $records = DB::table('past_papers')
            ->select('id', 'ques_paper', 'ans_paper')
            ->get();

        $fixed = [];

        foreach ($records as $row) {

            // -------- QUES PAPER --------
            if (!empty($row->ques_paper)) {

                if (
                    str_ends_with($row->ques_paper, 'pdf') &&
                    !str_ends_with($row->ques_paper, '.pdf')
                ) {
                    $oldFile = $path . '/' . $row->ques_paper;
                    $newName = substr($row->ques_paper, 0, -3) . '.pdf';
                    $newFile = $path . '/' . $newName;

                    if (file_exists($oldFile)) {
                        rename($oldFile, $newFile);

                        DB::table('past_papers')
                            ->where('id', $row->id)
                            ->update(['ques_paper' => $newName]);

                        $fixed[] = [
                            'id' => $row->id,
                            'type' => 'ques_paper',
                            'old' => $row->ques_paper,
                            'new' => $newName
                        ];
                    }
                }
            }

            // -------- ANSWER PAPER --------
            if (!empty($row->ans_paper)) {

                if (
                    str_ends_with($row->ans_paper, 'pdf') &&
                    !str_ends_with($row->ans_paper, '.pdf')
                ) {
                    $oldFile = $path . '/' . $row->ans_paper;
                    $newName = substr($row->ans_paper, 0, -3) . '.pdf';
                    $newFile = $path . '/' . $newName;

                    if (file_exists($oldFile)) {
                        rename($oldFile, $newFile);

                        DB::table('past_papers')
                            ->where('id', $row->id)
                            ->update(['ans_paper' => $newName]);

                        $fixed[] = [
                            'id' => $row->id,
                            'type' => 'ans_paper',
                            'old' => $row->ans_paper,
                            'new' => $newName
                        ];
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'fixed_files' => $fixed
        ]);
    }
}
