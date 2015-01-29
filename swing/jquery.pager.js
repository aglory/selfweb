
/*
* Pager
*/
(function ($)
{   
    $.fn.pager = function (options)
    {
        var opts = $.extend({}, $.fn.pager.defaults, options);        

        return this.each(function ()
        {
            // empty out the destination element and then render out the pager with the supplied options
            $(this).empty().append(renderpager(parseInt(options.pageIndex), parseInt(options.pageSize), parseInt(options.recordCount), options.pageIndexChanged));

            // specify correct cursor activity
            // $('.pages li').mouseover(function () { document.body.style.cursor = "pointer"; }).mouseout(function () { document.body.style.cursor = "auto"; });
        });
    };

    // render and return the pager with the supplied options
    function renderpager(pageIndex, pageSize, recordCount, pageIndexChanged)
    {
        if(recordCount==0) return "";
        var pageCount = Math.ceil(recordCount / pageSize);

        // setup $pager to hold render
        var $pager = $('<ul class="pages"></ul>');

        // add in the previous and next buttons
        $pager.append(renderButton('首页', pageIndex, pageSize, pageCount, pageIndexChanged))
        .append(renderButton('上一页', pageIndex, pageSize, pageCount, pageIndexChanged));

        // pager currently only handles 10 viewable pages ( could be easily parameterized, maybe in next version ) so handle edge cases
        var startPoint = 1;
        var endPoint = 9;

        if (pageIndex > 4)
        {
            startPoint = pageIndex - 4;
            endPoint = pageIndex + 4;
        }

        if (endPoint > pageCount)
        {
            startPoint = pageCount - 8;
            endPoint = pageCount;
        }

        if (startPoint < 1)
        {
            startPoint = 1;
        }

        // loop thru visible pages and render buttons
        for (var page = startPoint; page <= endPoint; page++)
        {
            var currentButton = $('<li class="page-number">' + (page) + '</li>');

            page == pageIndex ? currentButton.addClass('pgCurrent') : currentButton.click(function () { pageIndexChanged(this.firstChild.data, pageSize); });
            currentButton.appendTo($pager);
        }

        // render in the next and last buttons before returning the whole rendered control back.
        $pager.append(renderButton('下一页', pageIndex, pageSize, pageCount, pageIndexChanged))
        .append(renderButton('尾页', pageIndex, pageSize, pageCount, pageIndexChanged));

        return $pager;
    }

    // renders and returns a 'specialized' button, ie 'next', 'previous' etc. rather than a page number button
    function renderButton(buttonLabel, pageIndex, pageSize, pageCount, pageIndexChanged)
    {
        var $Button = $('<li class="pgNext">' + buttonLabel + '</li>');

        var destPage = 1;

        // work out destination page for required button type
        switch (buttonLabel)
        {
            case "首页":
                destPage = 1;
                break;
            case "上一页":
                destPage = pageIndex - 1;
                break;
            case "下一页":
                destPage = pageIndex + 1;
                break;
            case "尾页":
                destPage = pageCount;
                break;
        }

        // disable and 'grey' out buttons if not needed.
        if (buttonLabel == "首页" || buttonLabel == "上一页")
        {
            pageIndex <= 1 ? $Button.addClass('pgEmpty') : $Button.click(function () { pageIndexChanged(destPage, pageSize); });
        }
        else
        {
            pageIndex >= pageCount ? $Button.addClass('pgEmpty') : $Button.click(function () { pageIndexChanged(destPage, pageSize); });
        }

        return $Button;
    }

    // pager defaults. hardly worth bothering with in this case but used as placeholder for expansion in the next version
    $.fn.pager.defaults = {
        pageIndex: 1,
        pageSize: 20
    };

})(jQuery);





