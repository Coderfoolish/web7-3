$(function () {
    const pagesCache = {};

    function loadPage(page, addToHistory = true) {
        if (!page) page = "ctdtPage"; // Default page

        // Prevent reloading the same page
        if ($("#main-content").data("current-page") === page) return;

        $("#main-content").data("current-page", page);

        $(".nav-link").removeClass("active");
        $(`.nav-link[data-page="${page}"]`).addClass("active");

        // Remove previous scripts
        $(".nav-link").each(function () {
            let previousPage = $(this).data("page");
            if (previousPage !== page) {
                removeSubpageScript(previousPage);
            }
        });

        // Load content
        $("#main-content").load(`./views/admin/${page}.php`, function () {
            let scriptSrc = `./views/javascript/${page}.js`;

            if (!document.getElementById(page + "-script")) {
                $.ajax({
                    url: scriptSrc,
                    type: "HEAD",
                    success: function () {
                        let script = document.createElement("script");
                        script.src = scriptSrc;
                        script.type = "text/javascript";
                        script.id = page + "-script";
                        document.body.appendChild(script);
                    },
                    error: function () {
                        console.warn("JavaScript file not found: " + scriptSrc);
                    }
                });
            }

            if (addToHistory) {
                let newUrl = window.location.pathname + "?page=" + page;
                history.pushState({ page: page }, "", newUrl);
            }
        });
    }

    function removeSubpageScript(page) {
        let script = document.getElementById(page + "-script");
        if (script) {
            script.remove();
        }
    }

    // Click event for navigation links
    $(".nav-link").on("click", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        loadPage(page);
    });

    // Handle browser back/forward buttons
    window.onpopstate = function (event) {
        if (event.state && event.state.page) {
            loadPage(event.state.page, false);
        }
    };

    // Load the initial page from URL
    let urlParams = new URLSearchParams(window.location.search);
    let initialPage = urlParams.get("page") || "ctdtPage";
    loadPage(initialPage, false);
});
