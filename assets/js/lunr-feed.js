---
---
var hostname = "{{site.url}}{{site.baseurl}}";
var index = lunr(function () {
    this.field('title')
    this.field('content', {boost: 10})
    this.field('category')
    this.field('tags')
    this.ref('id')
});

{% assign count = 0 %}
{% for post in site.posts %}
    index.add({
        title: {{post.title | jsonify}},
        category: {{post.category | jsonify}},
        content: {{post.content | strip_html | jsonify}},
        tags: {{post.tags | jsonify}},
        id: {{count}}
    });
    {% assign count = count | plus: 1 %}
{% endfor %}

var store = [{% for post in site.posts %}{
    "title": {{post.title | jsonify}},
    "link": {{ post.url | jsonify }},
    "image": {{ post.image | jsonify }},
    "date": {{ post.date | date: '%-d %b, %Y' | jsonify }},
    "category": {{ post.category | jsonify }},
    "content": {{ post.content | jsonify }},
    "excerpt": {{ post.content | strip_html | truncatewords: 20 | jsonify }}
}{% unless forloop.last %},{% endunless %}{% endfor %}]

jQuery(document).ready(function() {
    jQuery('#search-input').on('keyup', function () {
        jQuery('#results-container').show();
        var resultdiv = jQuery('#mCSB_1_container');
        if (!resultdiv.is(':visible'))
            resultdiv.show();
        var query = jQuery(this).val();
        var result = index.search(query);
        resultdiv.empty();

        for (var item in result) {
            var ref = result[item].ref;
            var searchitem =
                '<li>' +
                    '<a class="clear" href="'+ hostname + store[ref].link+'">' +
                        '<figure style="background-image: url('+ jQuery(store[ref].content).find('img:first-of-type').attr('src') +');"></figure>' +
                        '<h2 itemprop="name headline">' + store[ref].title + '</h2>' +
                        '<time itemprop="datePublished">' + store[ref].date + '</time>' +
                        '<span class="category">' + store[ref].category + '</span>' +
                    '</a>' +
                '</li>';
            resultdiv.append(searchitem);
        }
    });
});
