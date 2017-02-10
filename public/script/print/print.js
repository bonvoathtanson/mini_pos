var Print = function(displayTitle, options, data) {
    var settings = $.extend({
        PageSize: 'container-A4',
        title: displayTitle,
        header: '',
        footer: ''
    }, options);
    var windowprint = window.open('', settings.title,'');
    windowprint.document.write('<html><head><title>'+settings.title+'</title>');
    windowprint.document.write('<link rel="stylesheet" href="'+burl+'/css/print.css" media="all" title="no title" charset="utf-8">');
    windowprint.document.write('<style media="all" type="text/css">');
    windowprint.document.write('@media screen, print{.no-print,.no-print *{display: none !important;}}');
    windowprint.document.write('</style></head>');
    windowprint.document.write('<body><div class ="'+settings.PageSize+'">');
    windowprint.document.write('<div class="font-M1 center" style="font-size:14pt;">ភ្នំពេញខ្សាច់</div>');
    windowprint.document.write('<div class="font-M1 center" style="font-size:12pt;">'+settings.title+'</div>');
    windowprint.document.write('<div class="font-HA center" style="font-size:11pt;font-HA">អាស័យដ្ឋានៈ វិថីស៊ីសុវិត្ថិ សង្កាត់ស្រះចក ខណ្ឌដូនពេញ រាជធានីភ្នំពេញ</div>');
    windowprint.document.write('<div class="font-HA center" style="font-size:11pt;font-HA">លេខទូរស័ព្ទៈ ០១៧​ ៨៦ ៨៨ ៦៧</div>');
    windowprint.document.write('<div class="print-body">');
    windowprint.document.write(data);
    windowprint.document.write('</div></div></body></html>');
    windowprint.document.close();
    windowprint.focus();
    windowprint.print();
    windowprint.close();
};
