---
---

svg4everybody();

jQuery(document).ready( function() {

	/* Fires search results's custom scroll. */
		jQuery(window).on('load', function(){
			jQuery(".results-container").mCustomScrollbar({
				theme: "dark-thick"
			});
		});
	/**/

	// Automatically sets the first post image as a featured image on Facebook and Twitter.
	var firstImg = jQuery('.post.single').find('img:first-of-type');
	var firstImgSrc = firstImg.attr('src');
	if (typeof firstImgSrc !== 'undefined') {
		jQuery('meta[property="og:image"]').attr('content', firstImgSrc);
		jQuery('meta[name="twitter:image"]').attr('content', firstImgSrc);
	}

	/* Fires fitVids plugin. */
        jQuery(".delicious main").fitVids();
	/**/

	/* Get first post image and make it thumbnail. */
		function generateThumbs() {
			function createNewImgIndex(url, src, el) {
                jQuery('<a href="' + url + '" style="background-image: url('+ src +');"></a>').prependTo(el);
			}

            jQuery('.index .post').each( function() {
				var postURL = jQuery(this).find('.post-title a').attr('href');
				var firstImg = jQuery(this).find('img:first-of-type');
				var firstImgSrc = firstImg.attr('src');
				if (typeof firstImgSrc !== 'undefined') {
					createNewImgIndex(postURL, firstImgSrc, this);
					firstImg.parent().remove();
					firstImg.parent().parent().parent().find('.post-excerpt').remove();
				}
			});

            jQuery('.index .post > a').wrap('<div class="post-image" />');
		}
	/**/

	generateThumbs();

	/* Category detector. */
		// Without "main".
		var availableCategories = [ "asian", "bbq", "beer", "breakfast", "cocktail", "coffee", "dessert", "drink", "fruit", "junk", "meat", "pasta", "pizza", "salad", "seafood", "snack", "soup", "tea", "vegetarian", "vegan" ];

		function categoryDetector() {
			jQuery('.index .posts .post').each( function() {
				var postURL = jQuery(this).find('.post-title a').attr('href');
				var tags = jQuery(this).find('.category a');
				var tagsText = tags.text().toLowerCase().replace(/\s/g, "");
				var tagIndex = jQuery.inArray(tagsText, availableCategories);
				if (jQuery.inArray(tagsText, availableCategories) !== -1) {
					jQuery('<a href="' + postURL + '" class="category-' + tagsText + '"><svg width="60" height="60"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="{{ site.baseurl | prepend: site.url }}/assets/svg/food-categories.svg#' + availableCategories[tagIndex] + '"></use></svg></a>').appendTo(jQuery(this).find('.post-image'));
				}
				else {
					jQuery('<a href="' + postURL + '" class="category-main"><svg width="60" height="60"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="{{ site.baseurl | prepend: site.url }}/assets/svg/food-categories.svg#main"></use></svg></a>').appendTo(jQuery(this).find('.post-image'));
				}
			});
		}

		categoryDetector();
	/**/

	/* Make first unordered list in the post - recipe list. */
		var getFirstUnList = jQuery('.post.single .post-content').find('ul:first-of-type:first');
		getFirstUnList.addClass('recipe-ingredients').attr('id', 'recipe-ingredients').appendTo('.post-content');
		getFirstUnList.find('li').on('click', function() {
            jQuery(this).toggleClass('selected');
		});
	/**/

	/* Hides search results box. */
    jQuery(document).on('click focus', function(e) {
        if (jQuery(e.target).closest('.share').length === 0 && jQuery(e.target).closest('#search-input').length === 0) {
            jQuery('.results-container').hide();
            jQuery('#search-input').val('');
        }
    });
	/**/
});