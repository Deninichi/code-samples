( function( $ ) {

    $(document).ready(function (){
        supportPosts.init();
    });

    const supportPosts = {
        activeTag: '',
        init() {
            this.initPosts();
            this.initTagsHandler();
        },
        initPosts() {
            const firstTag = $('.support-posts-container .tags-wrap li:first-child a');
            if( firstTag.length > 0 ) {
                this.activeTag = firstTag.data('tag');
                this.changeTag();
            }
        },
        initTagsHandler() {
            $('.support-posts-container .tags-wrap li a').on('click', (e) => {
                e.preventDefault();
                this.activeTag = e.target.dataset.tag;
                this.changeTag();
            })
        },

        changeTag() {
            const activeTag = this.activeTag;

            $('.support-posts-container .tags-wrap li a').removeClass('active');
            $('.support-posts-container .support-posts-wrap article').removeClass('active');

            $('.support-posts-container .tags-wrap li a[data-tag="' + this.activeTag + '"]').addClass('active');

            $('.support-posts-container .support-posts-wrap article').each(function(){
               const tags = $(this).data('tag');

               if( tags.includes(activeTag) ) {
                   $(this).addClass('active');
               }
            });
        }
    };

} )( jQuery );
