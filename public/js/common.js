$('document').ready(function () {
    Holidayextras.searchTags = '';
    Holidayextras.newSearch = true;
    Holidayextras.imgsContent = $('.wrapper .grid');
    Holidayextras.grid = $('#grid');
    Holidayextras.currentPage = 1;


    Holidayextras.loadPage({"page" : 1});
    Holidayextras.initListeners();
});

