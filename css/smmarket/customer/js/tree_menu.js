$.fn.tree_menu = function() {
    var nav = this;
    var uls = nav.find("ul");
    var coci_MENU= getcookie( "MENU" );
    if (coci_MENU) {
        setcookie( "MENU",coci_MENU ,30*3600*24*1000 );

        // тут получаем индексы из куки и перебираем их:
        var showedElems = ( coci_MENU || "" ).split(",");
        for( var i = 0; i < showedElems.length; i++ ) {
            // отображаем при загрузке то что надо.
            $( uls[ showedElems[ i ] ] ).prev('a').addClass('active')  //Добавляем класс к Активным эл-там меню;
            $( uls[ showedElems[ i ] ] ).show();
        }}


    //Добавляем класс к ссылке на текущую страницу, если она есть;
    var Url = document.URL.split('#')[0];
    $('> li ul',nav).find('a:not([href^="#"])').each(function() {
        var S = $(this).attr('href').split('#')[0];
        if(S&&Url.indexOf(S)!=-1) $(this).parent().addClass('a-active');
    });

    nav.find("a").click(function() {
        var Lnk=$(this).attr("href");
        if(Lnk==''||Lnk.indexOf('#')==0) setcookie( "MENU",1 ,-1);
        var self = $(this).next();
        if ( self.length == 0 ) return;


        var showedElems = [];
        uls.each(function( index ){

            if ( this === self[0] ) {
                if ( self.css('display') == "none" ) {
                    showedElems.push(index);$(this).prev('a').addClass('active');
                }  else $(this).prev('a').removeClass('active');
                $( this ).slideToggle(400);return true;
            }
            if ( jQuery.inArray( this, self.parents( "ul" ) ) == -1 ) {
                $(this).prev('a').removeClass('active');$(this).slideUp(400);return true;
            }
            showedElems.push(index);
        });

        // эту переменную  суём в куки,
        setcookie( "MENU", showedElems.join(",") ,30*3600*24*1000 );

        return false;

    });
}