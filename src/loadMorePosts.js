jQuery(document).ready(function ($) {
    $("#load-more").on("click", function (e) {
        e.preventDefault();
        let offset = $("#load-more").data("offset") || 3;
        let attributes = $("#load-more").data("attributes");
        $("#load-more").html("loading");

        fetch(`../wp-json/wp/v2/posts?per_page=3&offset=${offset}`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                data.forEach((post) => {
                    $('.row').append(`
                    <div class="col-sm-6 col-md-4">
                    <div class ="post">
                    ${attributes.displayFeaturedImage ? `<div class="post-image">${post.featuredImage}</div>` : ''}
                    <div class="post-content">
                        <h3>${post.title.rendered}</h3>
                        <p>${post.content.rendered}</p></div></div></div>`);
                });
                offset += 3;
                $("#load-more").data("offset", offset);
                $("#load-more").html("Load More");
                if (data.length < 3) {
                    $("#load-more").css("display", "none");
                }
            })
            .catch((error) => {
                console.error(error);
            });
    });
});
