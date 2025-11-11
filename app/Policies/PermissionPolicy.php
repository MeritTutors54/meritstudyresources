<?php

namespace App\Policies;

use App\Models\Admin;

class PermissionPolicy
{
    public function viewForAdminRole(Admin $admin): bool
    {
        return $admin->hasPermissionTo('view permissions');
    }

    public function syncForSuperAdminRole(Admin $admin): bool
    {
        if ($admin->hasAnyRole(['admin', 'editor'])) {
            return false;
        }

        return true;
    }


    /**
     * TESTIMONIAL
     **/
    public function viewTestimonial(Admin $admin)
    {
        return $admin->hasPermissionTo('view testimonial');
    }

    public function createTestimonial(Admin $admin)
    {
        return $admin->hasPermissionTo('create testimonial');
    }

    public function updateTestimonial(Admin $admin)
    {
        return $admin->hasPermissionTo('update testimonial');
    }

    public function deleteTestimonial(Admin $admin)
    {
        return $admin->hasPermissionTo('delete testimonial');
    }


    /**
     * MISC
     **/
    public function viewInquires(Admin $admin)
    {
        return $admin->hasPermissionTo('view customer inquiries');
    }

    public function viewNewsLatter(Admin $admin)
    {
        return $admin->hasPermissionTo('view newsletter');
    }

    public function viewDeliveryCharge(Admin $admin)
    {
        return $admin->hasPermissionTo('view delivery charge');
    }

    public function updateDeliveryCharge(Admin $admin)
    {
        return $admin->hasPermissionTo('update delivery charge');
    }


    /**
     * SITE SETTINGS
     **/
    public function viewSiteSettings(Admin $admin)
    {
        return $admin->hasPermissionTo('view site settings');
    }

    public function updateSiteSettings(Admin $admin)
    {
        return $admin->hasPermissionTo('update site settings');
    }

    /**
     * PAST PAPER CATEGORY
     **/
    public function viewPastPaperCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('view past paper category');
    }

    public function createPastPaperCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('create past paper category');
    }

    public function updatePastPaperCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('update past paper category');
    }

    public function deletePastPaperCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('delete past paper category');
    }

    /**
     * PAST PAPER SUBCATEGORY
     **/
    public function viewPastPaperSubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('view past paper subcategory');
    }

    public function createPastPaperSubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('create past paper subcategory');
    }

    public function updatePastPaperSubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('update past paper subcategory');
    }

    public function deletePastPaperSubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('delete past paper subcategory');
    }

    /**
     * PAST PAPER RESUBCATEGORY
     **/
    public function viewPastPaperResubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('view past paper resubcategory');
    }

    public function createPastPaperResubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('create past paper resubcategory');
    }

    public function updatePastPaperResubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('update past paper resubcategory');
    }

    public function deletePastPaperResubcategory(Admin $admin)
    {
        return $admin->hasPermissionTo('delete past paper resubcategory');
    }

    /**
     * PAST PAPER EXAM SERIES
     **/
    public function viewExamSeries(Admin $admin)
    {
        return $admin->hasPermissionTo('view exam series');
    }

    public function createExamSeries(Admin $admin)
    {
        return $admin->hasPermissionTo('create exam series');
    }

    public function updateExamSeries(Admin $admin)
    {
        return $admin->hasPermissionTo('update exam series');
    }

    public function deleteExamSeries(Admin $admin)
    {
        return $admin->hasPermissionTo('delete exam series');
    }

    /**
     * PAST PAPER
     **/
    public function viewPastPaper(Admin $admin)
    {
        return $admin->hasPermissionTo('view past paper');
    }

    public function createPastPaper(Admin $admin)
    {
        return $admin->hasPermissionTo('create past paper');
    }

    public function updatePastPaper(Admin $admin)
    {
        return $admin->hasPermissionTo('update past paper');
    }

    public function deletePastPaper(Admin $admin)
    {
        return $admin->hasPermissionTo('delete past paper');
    }


    /**
     * BLOG CATEGORY
     **/
    public function viewBlogCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('view blog category');
    }

    public function createBlogCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('create blog category');
    }

    public function updateBlogCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('update blog category');
    }

    public function deleteBlogCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('delete blog category');
    }

    /**
     * BLOG
     **/
    public function viewBlog(Admin $admin)
    {
        return $admin->hasPermissionTo('view blog');
    }

    public function createBlog(Admin $admin)
    {
        return $admin->hasPermissionTo('create blog');
    }

    public function updateBlog(Admin $admin)
    {
        return $admin->hasPermissionTo('update blog');
    }

    public function deleteBlog(Admin $admin)
    {
        return $admin->hasPermissionTo('delete blog');
    }

    /**
     * BLOG COMMENT
     **/
    public function viewBlogComment(Admin $admin)
    {
        return $admin->hasPermissionTo('view blog comment');
    }

    public function authorizeBlogComment(Admin $admin)
    {
        return $admin->hasPermissionTo('authorize blog comment');
    }

    public function replyBlogComment(Admin $admin)
    {
        return $admin->hasPermissionTo('reply blog comment');
    }

    /**
     * SUBSCRIPTION PLAN
     **/
    public function viewSubscriptionPlan(Admin $admin)
    {
        return $admin->hasPermissionTo('view subscription plan');
    }

    public function updateSubscriptionPlan(Admin $admin)
    {
        return $admin->hasPermissionTo('update subscription plan');
    }

    /**
     * EDUCATIONAL LEVEL
     **/
    public function viewEducationalLevel(Admin $admin)
    {
        return $admin->hasPermissionTo('view educational level');
    }

    public function createEducationalLevel(Admin $admin)
    {
        return $admin->hasPermissionTo('create educational level');
    }

    public function updateEducationalLevel(Admin $admin)
    {
        return $admin->hasPermissionTo('update educational level');
    }

    public function deleteEducationalLevel(Admin $admin)
    {
        return $admin->hasPermissionTo('delete educational level');
    }

    /**
     * SUBJECT
     */
    public function viewStudyMaterialSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('view study material subject');
    }

    public function createStudyMaterialSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('create study material subject');
    }

    public function updateStudyMaterialSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('update study material subject');
    }

    public function deleteStudyMaterialSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('delete study material subject');
    }


    /**
     * TOPIC
     */
    public function viewStudyMaterialTopic(Admin $admin)
    {
        return $admin->hasPermissionTo('view study material topic');
    }

    public function createStudyMaterialTopic(Admin $admin)
    {
        return $admin->hasPermissionTo('create study material topic');
    }

    public function updateStudyMaterialTopic(Admin $admin)
    {
        return $admin->hasPermissionTo('update study material topic');
    }

    public function deleteStudyMaterialTopic(Admin $admin)
    {
        return $admin->hasPermissionTo('delete study material topic');
    }

    /**
     * MATERIAL UPLOAD
     */
    public function viewStudyMaterialUpload(Admin $admin)
    {
        return $admin->hasPermissionTo('view study material upload');
    }

    public function createStudyMaterialUpload(Admin $admin)
    {
        return $admin->hasPermissionTo('create study material upload');
    }

    public function updateStudyMaterialUpload(Admin $admin)
    {
        return $admin->hasPermissionTo('update study material upload');
    }

    public function deleteStudyMaterialUpload(Admin $admin)
    {
        return $admin->hasPermissionTo('delete study material upload');
    }


    /**
     * BOOK CATEGORY
     */
    public function viewBookCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('view book category');
    }

    public function createBookCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('create book category');
    }

    public function updateBookCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('update book category');
    }

    public function deleteBookCategory(Admin $admin)
    {
        return $admin->hasPermissionTo('delete book category');
    }

    /**
     * BOOK SUBJECT
     */

    public function viewBookSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('view book subject');
    }

    public function createBookSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('create book subject');
    }

    public function updateBookSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('update book subject');
    }

    public function deleteBookSubject(Admin $admin)
    {
        return $admin->hasPermissionTo('delete book subject');
    }


    /**
     * BOOK VARIANT
     */
    public function viewBookVariant(Admin $admin)
    {
        return $admin->hasPermissionTo('view book variant');
    }

    public function createBookVariant(Admin $admin)
    {
        return $admin->hasPermissionTo('create book variant');
    }

    public function updateBookVariant(Admin $admin)
    {
        return $admin->hasPermissionTo('update book variant');
    }

    public function deleteBookVariant(Admin $admin)
    {
        return $admin->hasPermissionTo('delete book variant');
    }

    /**
     * PRODUCT
     */
    public function viewProduct(Admin $admin)
    {
        return $admin->hasPermissionTo('view product');
    }

    public function createProduct(Admin $admin)
    {
        return $admin->hasPermissionTo('create product');
    }

    public function updateProduct(Admin $admin)
    {
        return $admin->hasPermissionTo('update product');
    }

    public function deleteProduct(Admin $admin)
    {
        return $admin->hasPermissionTo('delete product');
    }


    /**
     * ORDER
     */
    public function viewOrderDetails(Admin $admin)
    {
        return $admin->hasPermissionTo('view order details');
    }

    public function updateOrderTracking(Admin $admin)
    {
        return $admin->hasPermissionTo('update order tracking');
    }

    /**
     * COUPON
     */
    public function viewCoupon(Admin $admin)
    {
        return $admin->hasPermissionTo('view coupon');
    }

    public function createCoupon(Admin $admin)
    {
        return $admin->hasPermissionTo('create coupon');
    }

    public function updateCoupon(Admin $admin)
    {
        return $admin->hasPermissionTo('update coupon');
    }

    public function deleteCoupon(Admin $admin)
    {
        return $admin->hasPermissionTo('delete coupon');
    }


    /**
     * SOCIAL
     */
    public function viewSocial(Admin $admin)
    {
        return $admin->hasPermissionTo('view social');
    }

    public function createSocial(Admin $admin)
    {
        return $admin->hasPermissionTo('create social');
    }

    public function updateSocial(Admin $admin)
    {
        return $admin->hasPermissionTo('update social');
    }

    public function deleteSocial(Admin $admin)
    {
        return $admin->hasPermissionTo('delete social');
    }


    /**
     * SEO
     */
    public function viewSEO(Admin $admin)
    {
        return $admin->hasPermissionTo('view seo');
    }

    public function createSEO(Admin $admin)
    {
        return $admin->hasPermissionTo('create seo');
    }

    public function updateSEO(Admin $admin)
    {
        return $admin->hasPermissionTo('update seo');
    }

    public function deleteSEO(Admin $admin)
    {
        return $admin->hasPermissionTo('delete seo');
    }


    /**
     * POLICY
     */
    public function viewPolicy(Admin $admin)
    {
        return $admin->hasPermissionTo('view policy');
    }

    public function createPolicy(Admin $admin)
    {
        return $admin->hasPermissionTo('create policy');
    }

    public function updatePolicy(Admin $admin)
    {
        return $admin->hasPermissionTo('update policy');
    }

    public function deletePolicy(Admin $admin)
    {
        return $admin->hasPermissionTo('delete policy');
    }


    /**
     * FAQ
     */
    public function viewFAQ(Admin $admin)
    {
        return $admin->hasPermissionTo('view faq');
    }

    public function createFAQ(Admin $admin)
    {
        return $admin->hasPermissionTo('create faq');
    }

    public function updateFAQ(Admin $admin)
    {
        return $admin->hasPermissionTo('update faq');
    }

    public function deleteFAQ(Admin $admin)
    {
        return $admin->hasPermissionTo('delete faq');
    }

    /**
     * ADMIN STUFF
     */
    public function createStuff(Admin $admin)
    {
        return $admin->hasPermissionTo('create stuff');
    }

    public function updateStuffPermission(Admin $admin)
    {
        return $admin->hasPermissionTo('update stuff permission');
    }
    public function editStuff(Admin $admin)
    {
        return $admin->hasPermissionTo('edit stuff');
    }

    public function deleteStuff(Admin $admin)
    {
        return $admin->hasPermissionTo('delete stuff');
    }
}
