<?php
/**
 * New fundraiser form template in the widget.
 *
 * @package gop
 */

$user_id         = get_current_user_id();
$email_confirmed = get_user_meta( $user_id, 'email_confirmed', true );
$redirect_url    = '/fundraiser-ready?user_id=' . $user_id;
if ( $user_id ) {
    $gop_user = new GOP_User( $user_id );
    if ( $gop_user->has_paid_subscription() ) {
        $redirect_url = get_permalink( get_option( 'wpneo_crowdfunding_dashboard_page_id' ) );
    }
}

?>
<div class="new-fundraiser-form">
    <h3 class="heading">Let's Get Started!</h3>
    <?php if ( is_user_logged_in() ) : ?>
        <div class="steps">
            <div class="bar">
                <div class="progress"></div>
            </div>
            <div class="current-step">Step <span class="step">1</span> of 4</div>
        </div>
        <form action="" data-redirect="<?php echo esc_attr( $redirect_url ); ?>">
            <div class="step-wrap" data-step="1">
                <p>To build your customized fundraiser campaign, we’ll just need a few details…</p>
                <div class="question-wrap">
                    <div class="label">WHO ARE YOU FUNDRAISING FOR?<span class="required">*</span><span class="fa fa-info-circle typpy-tooltip"
                                                                                                        data-text='<p style="margin-left: 32px;"></p><p style="margin-left: 32px;"><ol></ol></p><p>Yourself:&nbsp;<em>You are raising money for your own fertility treatment, surrogacy, adoption, etc.</em></p><p style="margin-left: 32px;"><ol></ol></p><p>A family or friend<em>: You want to support a loved one’s path to parenthood with some extra funds.</em></p><p style="margin-left: 32px;"><ol></ol></p><p>For charity<em>: You’re paying it forward and raising money for other hopeful parents.</em></p>'></span>
                    </div>
                    <div class="radio-wrap">
                        <input type="radio" value="myself" name="fundraising_for" id="fundraising_for_myself" required>
                        <label for="fundraising_for_myself">MYSELF</label>
                    </div>
                    <div class="radio-wrap">
                        <input type="radio" value="family-friend" name="fundraising_for" id="fundraising_for_family" required>
                        <label for="fundraising_for_family">A FAMILY OR FRIEND</label>
                    </div>
                    <div class="radio-wrap">
                        <input type="radio" value="charity" name="fundraising_for" id="fundraising_for_charity" required>
                        <label for="fundraising_for_charity">FOR CHARITY</label>
                    </div>
                </div>

                <div class="question-wrap" style="display: none;" data-parent="fundraising_for_family">
                    <div class="label">INDIVIDUAL NAME<span class="required">*</span></div>
                    <div class="input-wrap">
                        <input type="text" value="" name="individual_name" id="individual_name" placeholder="Name" required>
                    </div>
                </div>

                <div class="question-wrap" style="display: none;" data-parent="fundraising_for_family">
                    <div class="label">INDIVIDUAL RELATIONSHIP<span class="required">*</span></div>
                    <div class="input-wrap">
                        <input type="text" value="" name="individual_relationship" id="individual_relationship" placeholder="Relationship" required>
                    </div>
                </div>

                <div class="question-wrap" style="display: none;" data-parent="fundraising_for_family">
                    <div class="checkbox-wrap">
                        <input type="checkbox" value="yes" name="individual_permission" id="individual_permission" required>
                        <div class="label">I HAVE PERMISSION FROM THIS INDIVIDUAL TO POST ON THEIR BEHALF<span class="required">*</span></div>
                    </div>
                </div>
            </div>

            <div class="step-wrap" data-step="2" style="display: none">
                <p>This is the fun part! Let’s make this campaign YOURS.</p>
                <div class="question-wrap">
                    <div class="label">WHAT IS YOUR FUNDRAISER TITLE?<span class="required">*</span><span class="fa fa-info-circle typpy-tooltip" data-text="Adding a short headline to your fundraiser will encourage donors to learn about your cause. Example titles: “Help Kelly &amp; Mike complete their family with IVF,” or “Support hopeful parents with grant money from Gift of Parenthood."></span></div>
                    <div class="description">Keep it simple yet informative by using a name/organization and the purpose of the fundraiser.</div>
                    <div class="input-wrap">
                        <input type="text" name="fundraiser_name" id="fundraiser_name" required>
                    </div>
                    <div class="description">50 of 50 Character(s) left</div>
                </div>

                <div class="question-wrap">
                    <div class="label">SET YOUR FUNDRAISING GOAL<span class="required">*</span><span class="fa fa-info-circle typpy-tooltip" data-text="Not sure where to begin? We recommend starting at $1,000 and adjusting later as needed. You always have the option to lower or raise your goal later on."></span></div>
                    <div class="description">How much would you like to raise?</div>
                    <div class="input-wrap">
                        <input type="text" id="amount" name="fundraiser_goal" id="fundraiser_goal" placeholder="$ Enter goal amount" required>
                    </div>
                </div>

                <div class="question-wrap">
                    <div class="label">CAMPAIGN START DATE<span class="required">*</span></div>
                    <div class="input-wrap">
                        <input type="text" class="fundraiser-datepicker" value="" name="fundraiser_start" id="fundraiser_start" required>
                    </div>
                </div>

                <div class="question-wrap">
                    <div class="label">CAMPAIGN END DATE<span class="required">*</span></div>
                    <div class="input-wrap">
                        <input type="text" class="fundraiser-datepicker" value="" name="fundraiser_end" id="fundraiser_end" required>
                    </div>
                </div>

                <div class="question-wrap">
                    <div class="label">CATEGORY<span class="required">*</span></div>
                    <div class="select-wrap">
                        <select name="fundraiser_category" id="fundraiser_category" required>
                            <?php /** @var WP_Term $category */ ?>
                            <?php foreach ( $categories as $category ) : ?>
                                <option value="<?php esc_attr_e( $category->slug ); ?>"><?php esc_attr_e( $category->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="step-wrap" data-step="3" style="display: none">
                <p>Make your campaign stand out with photos and videos.</p>
                <div class="question-wrap">
                    <div class="label">PHOTO UPLOAD (JPG, JPEG, PNG, OR BMP) <span class="fa fa-info-circle typpy-tooltip" data-text="You can upload up to 5 files. Maximum file size is 2MB per image."></span></div>
                    <input type="file" class="filepond" name="fundraiser_images[]" multiple data-allow-reorder="true" data-max-file-size="2MB" data-max-files="5"/>
                    <div class="error-message file-error"></div>
                </div>

                <div class="question-wrap">
                    <div class="label">VIDEO<span class="fa fa-info-circle typpy-tooltip" data-text="Videos bring life to your cause. Opt for 1 - 3 minute high-resolution video when you can."></span></div>
                    <div class="input-wrap">
                        <input type="text" value="" name="fundraiser_video" id="fundraiser_video" placeholder="Add a YouTube link">
                    </div>
                </div>
            </div>

            <div class="step-wrap" data-step="4" style="display: none">
                <p>Now is your time to shine! Explain who you are, who you’re fundraising for, and why it’s important to you.</p>
                <div class="question-wrap">
                    <div class="label">EXPLAIN WHO YOU ARE AND WHY YOU'RE FUNDRAISING<span class="required">*</span> <span class="fa fa-info-circle typpy-tooltip"
                                                                                                                           data-text='<p>Your story is the perfect opportunity to give donors all of the need-to-know information about you and your cause to encourage them to participate.&nbsp;<span style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif;">Here are some story-writing tips our fundraising expert to get you started.</span></p><p>To have the best campaign experience, make sure your story:</p><ul><li> Explains who you are and who the funds will benefit </li><li>Describes how the donations help a person or charity </li><li>Explains the charity’s cause if applicable </li><li>Detail where the funds will go </li></ul>'></span>
                    </div>
                    <div class="input-wrap">
                        <textarea name="fundraiser_description" rows="10" id="fundraiser_description" placeholder="" required></textarea>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button class="prev" style="display: none">Previous</button>
                <button class="next">Next</button>
            </div>
        </form>
    <?php else : ?>
        <p style="text-align: center; margin: 1em 0 4em; ">Do you have a Gift of Parenthood account?</p>
        <div class="elementor-widget-wrap gop-inline-buttons">
            <div class="elementor-widget-button elementor-widget__width-auto" style="margin:0 0.5em;"><a class="elementor-button-link elementor-button" href="/login/">Yes</a></div>
            <div class="elementor-widget-button elementor-widget__width-auto" style="margin:0 0.5em;"><a class="elementor-button-link elementor-button" href="/create-account/">No</a></div>
        </div>
    <?php endif; ?>
</div>
