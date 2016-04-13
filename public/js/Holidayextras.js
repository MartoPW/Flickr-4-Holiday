var Holidayextras = {
    "templates" : {
        "loadingMask": "<div id='loadingMask'><span>LOADING</span></div>",
        "gridItem": "<div class='grid-item' title='{{title}} by {{author}}'><div class='image'><a target='_blank' href='{{url}}'><img src='{{src}}' alt='{{title}}' /></a></div> <div class='info'><a target='_blank' title='{{title}}' href='{{url}}'>{{title}}</a> by <a target='_blank' title='{{author}}' href='{{author_url}}'>{{author}}</a></div> <div class='description' title='{{description}}'>{{#if description}}Description: <span>{{{description}}}</span>{{/if}}</div> <div class='tags' title='{{tags}}'>{{#if tags}}Tags: <span>{{tags}}</span>{{/if}}</div></div></div>",
        "paginator": "<div id='paginator'><a href='?page={{page}}'>Next</a></div>",
    },
    "initListeners": function () {
        $('#search').on('keyup', function (e) {
            if (e.keyCode == 13) Holidayextras.doSearch();
        });

        $('#allOrAny').on('click', function () {
            Holidayextras.doSearch(true)
        });


        $(window).on("scroll", function () {
            clearTimeout($.data(this, 'scrollTimer'));
            $.data(this, 'scrollTimer', setTimeout(function () {
                var scrollHeight = $(document).height();
                var scrollPosition = $(window).height() + $(window).scrollTop();
                if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
                    Holidayextras.doSearch();
                }
            }, 250));
        });
    },

    "loadingMask": function (hide) {
        if (hide == 'hide') {
            $('#loadingMask').remove();
        } else {
            if ($('#loadingMask').length > 0) $('#loadingMask').show();
            else $('body').prepend(Handlebars.compile(this.templates.loadingMask));
        }
    },

    "doSearch": function (forceNewSearch) {
        var params = {};
        if (this.searchTags != $('#search').val() || forceNewSearch == true) {
            this.newSearch = true;
            params.page = 1;
        } else {
            this.newSearch = false;
            params.page = ++this.currentPage;
        }
        if ($('#search').val().length > 0) {
            this.searchTags = params.tags = $('#search').val()
        }
        if ($('#allOrAny:checked').length > 0) {
            params.tag_mode = 'all';
        }
        this.loadPage(params);
    },

    "loadPage": function (params) {
        if(Holidayextras.currentPage > Holidayextras.totalPages && Holidayextras.newSearch == false){
            alert('You have seen them all, do another search please.')
            return false;
        }
        this.loadingMask();

        if (params == undefined) params = {};
        $.get("/ajax/json.php", params, function (data) {
            var data = $.parseJSON(data);
            Holidayextras.loadingMask('hide');
            if (data.success == false) {
                Holidayextras.grid.html('<div class="message">' + data.message + '</div>');
                return;
            }
            Holidayextras.currentPage = data.page;
            Holidayextras.totalPages = data.pages;
            var str = '';
            $.each(data.images, function (a, image) {
                str += Handlebars.compile(Holidayextras.templates.gridItem)({
                    "src": image.thumb_url,
                    "author": image.author_name,
                    "author_url": image.author_url,
                    "title": image.title,
                    "tags": image.tags,
                    "description": image.description,
                    "url": image.url
                });
            });
            if (Holidayextras.newSearch) {
                $(window).scrollTop(0);
                Holidayextras.grid.html(str);
            } else {
                Holidayextras.grid.append(str)
            }

        });
    }
}


