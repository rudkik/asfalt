(function(A){var J,T,R,K,d,w,I,N,z,D=0,H={},h=[],e=0,F={},y=[],f=null,m=new Image(),g=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,k=/[^\.]\.(swf)\s*$/i,q,L=1,a,c,O=false,C=20,t=A.extend(A("<div/>")[0],{prop:0}),j=0,S=!A.support.opacity&&!window.XMLHttpRequest,P=false,i=function(){T.hide();m.onerror=m.onload=null;if(f){f.abort()}J.empty()},p=function(){A.fancybox('<p id="fancybox_error">The requested content cannot be loaded.<br />Please try again later.</p>',{scrolling:"no",padding:20,transitionIn:"none",transitionOut:"none"})},E=function(){return[A(window).width(),A(window).height(),A(document).scrollLeft(),A(document).scrollTop()]},b=function(){var W=E(),ad={},ab=F.margin,X=F.autoScale,ac=(C+ab)*2,aa=(C+ab)*2,Y=(F.padding*2),Z;if(F.width.toString().indexOf("%")>-1){ad.width=((W[0]*parseFloat(F.width))/100)-(C*2);X=false}else{ad.width=F.width+Y}if(F.height.toString().indexOf("%")>-1){ad.height=((W[1]*parseFloat(F.height))/100)-(C*2);X=false}else{ad.height=F.height+Y}if(X&&(ad.width>(W[0]-ac)||ad.height>(W[1]-aa))){if(H.type=="image"||H.type=="swf"){ac+=Y;aa+=Y;Z=Math.min(Math.min(W[0]-ac,F.width)/F.width,Math.min(W[1]-aa,F.height)/F.height);ad.width=Math.round(Z*(ad.width-Y))+Y;ad.height=Math.round(Z*(ad.height-Y))+Y}else{ad.width=Math.min(ad.width,(W[0]-ac));ad.height=Math.min(ad.height,(W[1]-aa))}}ad.top=W[3]+((W[1]-(ad.height+(C*2)))*0.5);ad.left=W[2]+((W[0]-(ad.width+(C*2)))*0.5);if(F.autoScale===false){ad.top=Math.max(W[3]+ab,ad.top);ad.left=Math.max(W[2]+ab,ad.left)}return ad},M=function(W){if(W&&W.length){switch(F.titlePosition){case"inside":return W;case"over":return'<span id="fancybox-title-over">'+W+"</span>";default:return'<span id="fancybox-title-wrap"><span id="fancybox-title-left"></span><span id="fancybox-title-main">'+W+'</span><span id="fancybox-title-right"></span></span>'}}return false},s=function(){var Y=F.title,X=c.width-(F.padding*2),W="fancybox-title-"+F.titlePosition;A("#fancybox-title").remove();j=0;if(F.titleShow===false){return}Y=A.isFunction(F.titleFormat)?F.titleFormat(Y,y,e,F):M(Y);if(!Y||Y===""){return}A('<div id="fancybox-title" class="'+W+'" />').css({width:X,paddingLeft:F.padding,paddingRight:F.padding}).html(Y).appendTo("body");switch(F.titlePosition){case"inside":j=A("#fancybox-title").outerHeight(true)-F.padding;c.height+=j;break;case"over":A("#fancybox-title").css("bottom",F.padding);break;default:A("#fancybox-title").css("bottom",A("#fancybox-title").outerHeight(true)*-1);break}A("#fancybox-title").appendTo(d).hide()},o=function(){A(document).unbind("keydown.fb").bind("keydown.fb",function(W){if(W.keyCode==27&&F.enableEscapeButton){W.preventDefault();A.fancybox.close()}else{if(W.keyCode==37){W.preventDefault();A.fancybox.prev()}else{if(W.keyCode==39){W.preventDefault();A.fancybox.next()}}}});if(A.fn.mousewheel){K.unbind("mousewheel.fb");if(y.length>1){K.bind("mousewheel.fb",function(W,X){W.preventDefault();if(O||X===0){return}if(X>0){A.fancybox.prev()}else{A.fancybox.next()}})}}if(!F.showNavArrows){return}if((F.cyclic&&y.length>1)||e!==0){N.show()}if((F.cyclic&&y.length>1)||e!=(y.length-1)){z.show()}},U=function(){var W,X;if((y.length-1)>e){W=y[e+1].href;if(typeof W!=="undefined"&&W.match(g)){X=new Image();X.src=W}}if(e>0){W=y[e-1].href;if(typeof W!=="undefined"&&W.match(g)){X=new Image();X.src=W}}},v=function(){w.css("overflow",(F.scrolling=="auto"?(F.type=="image"||F.type=="iframe"||F.type=="swf"?"hidden":"auto"):(F.scrolling=="yes"?"auto":"visible")));if(!A.support.opacity){w.get(0).style.removeAttribute("filter");K.get(0).style.removeAttribute("filter")}A("#fancybox-title").show();if(F.hideOnContentClick){w.one("click",A.fancybox.close)}if(F.hideOnOverlayClick){R.one("click",A.fancybox.close)}if(F.showCloseButton){I.show()}o();A(window).bind("resize.fb",A.fancybox.center);if(F.centerOnScroll){A(window).bind("scroll.fb",A.fancybox.center)}else{A(window).unbind("scroll.fb")}if(A.isFunction(F.onComplete)){F.onComplete(y,e,F)}O=false;U()},G=function(aa){var X=Math.round(a.width+(c.width-a.width)*aa),W=Math.round(a.height+(c.height-a.height)*aa),Z=Math.round(a.top+(c.top-a.top)*aa),Y=Math.round(a.left+(c.left-a.left)*aa);K.css({width:X+"px",height:W+"px",top:Z+"px",left:Y+"px"});X=Math.max(X-F.padding*2,0);W=Math.max(W-(F.padding*2+(j*aa)),0);w.css({width:X+"px",height:W+"px"});if(typeof c.opacity!=="undefined"){K.css("opacity",(aa<0.5?0.5:aa))}},x=function(W){var X=W.offset();X.top+=parseFloat(W.css("paddingTop"))||0;X.left+=parseFloat(W.css("paddingLeft"))||0;X.top+=parseFloat(W.css("border-top-width"))||0;X.left+=parseFloat(W.css("border-left-width"))||0;X.width=W.width();X.height=W.height();return X},V=function(){var Z=H.orig?A(H.orig):false,Y={},X,W;if(Z&&Z.length){X=x(Z);Y={width:(X.width+(F.padding*2)),height:(X.height+(F.padding*2)),top:(X.top-F.padding-C),left:(X.left-F.padding-C)}}else{W=E();Y={width:1,height:1,top:W[3]+W[1]*0.5,left:W[2]+W[0]*0.5}}return Y},u=function(){T.hide();if(K.is(":visible")&&A.isFunction(F.onCleanup)){if(F.onCleanup(y,e,F)===false){A.event.trigger("fancybox-cancel");O=false;return}}y=h;e=D;F=H;w.get(0).scrollTop=0;w.get(0).scrollLeft=0;if(F.overlayShow){if(S){A("select:not(#fancybox-tmp select)").filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one("fancybox-cleanup",function(){this.style.visibility="inherit"})}R.css({"background-color":F.overlayColor,opacity:F.overlayOpacity}).unbind().show()}c=b();s();if(K.is(":visible")){A(I.add(N).add(z)).hide();var X=K.position(),W;a={top:X.top,left:X.left,width:K.width(),height:K.height()};W=(a.width==c.width&&a.height==c.height);w.fadeOut(F.changeFade,function(){var Y=function(){w.html(J.contents()).fadeIn(F.changeFade,v)};A.event.trigger("fancybox-change");w.empty().css("overflow","hidden");if(W){w.css({top:F.padding,left:F.padding,width:Math.max(c.width-(F.padding*2),1),height:Math.max(c.height-(F.padding*2)-j,1)});Y()}else{w.css({top:F.padding,left:F.padding,width:Math.max(a.width-(F.padding*2),1),height:Math.max(a.height-(F.padding*2),1)});t.prop=0;A(t).animate({prop:1},{duration:F.changeSpeed,easing:F.easingChange,step:G,complete:Y})}});return}K.css("opacity",1);if(F.transitionIn=="elastic"){a=V();w.css({top:F.padding,left:F.padding,width:Math.max(a.width-(F.padding*2),1),height:Math.max(a.height-(F.padding*2),1)}).html(J.contents());K.css(a).show();if(F.opacity){c.opacity=0}t.prop=0;A(t).animate({prop:1},{duration:F.speedIn,easing:F.easingIn,step:G,complete:v})}else{w.css({top:F.padding,left:F.padding,width:Math.max(c.width-(F.padding*2),1),height:Math.max(c.height-(F.padding*2)-j,1)}).html(J.contents());K.css(c).fadeIn(F.transitionIn=="none"?0:F.speedIn,v)}},r=function(){J.width(H.width);J.height(H.height);if(H.width=="auto"){H.width=J.width()}if(H.height=="auto"){H.height=J.height()}u()},Q=function(){O=true;H.width=m.width;H.height=m.height;A("<img />").attr({id:"fancybox-img",src:m.src,alt:H.title}).appendTo(J);u()},l=function(){i();var ab=h[D],Y,Z,ad,ac,X,W,aa;H=A.extend({},A.fn.fancybox.defaults,(typeof A(ab).data("fancybox")=="undefined"?H:A(ab).data("fancybox")));ad=ab.title||A(ab).title||H.title||"";if(ab.nodeName&&!H.orig){H.orig=A(ab).children("img:first").length?A(ab).children("img:first"):A(ab)}if(ad===""&&H.orig){ad=H.orig.attr("alt")}if(ab.nodeName&&(/^(?:javascript|#)/i).test(ab.href)){Y=H.href||null}else{Y=H.href||ab.href||null}if(H.type){Z=H.type;if(!Y){Y=H.content}}else{if(H.content){Z="html"}else{if(Y){if(Y.match(g)){Z="image"}else{if(Y.match(k)){Z="swf"}else{if(A(ab).hasClass("iframe")){Z="iframe"}else{if(Y.match(/#/)){ab=Y.substr(Y.indexOf("#"));Z=A(ab).length>0?"inline":"ajax"}else{Z="ajax"}}}}}else{Z="inline"}}}H.type=Z;H.href=Y;H.title=ad;if(H.autoDimensions&&H.type!=="iframe"&&H.type!=="swf"){H.width="auto";H.height="auto"}if(H.modal){H.overlayShow=true;H.hideOnOverlayClick=false;H.hideOnContentClick=false;H.enableEscapeButton=false;H.showCloseButton=false}if(A.isFunction(H.onStart)){if(H.onStart(h,D,H)===false){O=false;return}}J.css("padding",(C+H.padding+H.margin));A(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){A(this).replaceWith(w.children())});switch(Z){case"html":J.html(H.content);r();break;case"inline":A('<div class="fancybox-inline-tmp" />').hide().insertBefore(A(ab)).bind("fancybox-cleanup",function(){A(this).replaceWith(w.children())}).bind("fancybox-cancel",function(){A(this).replaceWith(J.children())});A(ab).appendTo(J);r();break;case"image":O=false;A.fancybox.showActivity();m=new Image();m.onerror=function(){p()};m.onload=function(){m.onerror=null;m.onload=null;Q()};m.src=Y;break;case"swf":ac='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+H.width+'" height="'+H.height+'"><param name="movie" value="'+Y+'"></param>';X="";A.each(H.swf,function(ae,af){ac+='<param name="'+ae+'" value="'+af+'"></param>';X+=" "+ae+'="'+af+'"'});ac+='<embed src="'+Y+'" type="application/x-shockwave-flash" width="'+H.width+'" height="'+H.height+'"'+X+"></embed></object>";J.html(ac);r();break;case"ajax":W=Y.split("#",2);aa=H.ajax.data||{};if(W.length>1){Y=W[0];if(typeof aa=="string"){aa+="&selector="+W[1]}else{aa.selector=W[1]}}O=false;A.fancybox.showActivity();f=A.ajax(A.extend(H.ajax,{url:Y,data:aa,error:p,success:function(af,ag,ae){if(f.status==200){J.html(af);r()}}}));break;case"iframe":A('<iframe id="fancybox-frame" name="fancybox-frame'+new Date().getTime()+'" frameborder="0" hspace="0" scrolling="'+H.scrolling+'" src="'+H.href+'"></iframe>').appendTo(J);u();break}},n=function(){if(!T.is(":visible")){clearInterval(q);return}A("div",T).css("top",(L*-40)+"px");L=(L+1)%12},B=function(){if(A("#fancybox-wrap").length){return}A("body").append(J=A('<div id="fancybox-tmp"></div>'),T=A('<div id="fancybox-loading"><div></div></div>'),R=A('<div id="fancybox-overlay"></div>'),K=A('<div id="fancybox-wrap"></div>'));if(!A.support.opacity){K.addClass("fancybox-ie");T.addClass("fancybox-ie")}d=A('<div id="fancybox-outer"></div>').append('<div class="fancy-bg" id="fancy-bg-n"></div><div class="fancy-bg" id="fancy-bg-ne"></div><div class="fancy-bg" id="fancy-bg-e"></div><div class="fancy-bg" id="fancy-bg-se"></div><div class="fancy-bg" id="fancy-bg-s"></div><div class="fancy-bg" id="fancy-bg-sw"></div><div class="fancy-bg" id="fancy-bg-w"></div><div class="fancy-bg" id="fancy-bg-nw"></div>').appendTo(K);d.append(w=A('<div id="fancybox-inner"></div>'),I=A('<a id="fancybox-close"></a>'),N=A('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),z=A('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));I.click(A.fancybox.close);T.click(A.fancybox.cancel);N.click(function(W){W.preventDefault();A.fancybox.prev()});z.click(function(W){W.preventDefault();A.fancybox.next()});if(S){R.get(0).style.setExpression("height","document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px'");T.get(0).style.setExpression("top","(-20 + (document.documentElement.clientHeight ? document.documentElement.clientHeight/2 : document.body.clientHeight/2 ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop )) + 'px'");d.prepend('<iframe id="fancybox-hide-sel-frame" src="javascript:\'\';" scrolling="no" frameborder="0" ></iframe>')}P=true};A.fn.fancybox=function(W){if(!P){B()}A(this).data("fancybox",A.extend({},W,(A.metadata?A(this).metadata():{}))).unbind("click.fb").bind("click.fb",function(Y){Y.preventDefault();if(O){return}O=true;A(this).blur();h=[];D=0;var X=A(this).attr("rel")||"";if(!X||X==""||X==="nofollow"){h.push(this)}else{h=A("a[rel="+X+"], area[rel="+X+"]");D=h.index(this)}l();return false});return this};A.fancybox=function(Z){if(!P){B()}if(O){return}O=true;var Y=typeof arguments[1]!=="undefined"?arguments[1]:{};h=[];D=Y.index||0;if(A.isArray(Z)){for(var X=0,W=Z.length;X<W;X++){if(typeof Z[X]=="object"){A(Z[X]).data("fancybox",A.extend({},Y,Z[X]))}else{Z[X]=A({}).data("fancybox",A.extend({content:Z[X]},Y))}}h=jQuery.merge(h,Z)}else{if(typeof Z=="object"){A(Z).data("fancybox",A.extend({},Y,Z))}else{Z=A({}).data("fancybox",A.extend({content:Z},Y))}h.push(Z)}if(D>h.length||D<0){D=0}l()};A.fancybox.showActivity=function(){clearInterval(q);T.show();q=setInterval(n,66)};A.fancybox.hideActivity=function(){T.hide()};A.fancybox.next=function(){return A.fancybox.pos(e+1)};A.fancybox.prev=function(){return A.fancybox.pos(e-1)};A.fancybox.pos=function(W){if(O){return}W=parseInt(W,10);if(W>-1&&y.length>W){D=W;l()}if(F.cyclic&&y.length>1&&W<0){D=y.length-1;l()}if(F.cyclic&&y.length>1&&W>=y.length){D=0;l()}return};A.fancybox.cancel=function(){if(O){return}O=true;A.event.trigger("fancybox-cancel");i();if(H&&A.isFunction(H.onCancel)){H.onCancel(h,D,H)}O=false};A.fancybox.close=function(){if(O||K.is(":hidden")){return}O=true;if(F&&A.isFunction(F.onCleanup)){if(F.onCleanup(y,e,F)===false){O=false;return}}i();A(I.add(N).add(z)).hide();A("#fancybox-title").remove();K.add(w).add(R).unbind();A(window).unbind("resize.fb scroll.fb");A(document).unbind("keydown.fb");function W(){R.fadeOut("fast");K.hide();A.event.trigger("fancybox-cleanup");w.empty();if(A.isFunction(F.onClosed)){F.onClosed(y,e,F)}y=H=[];e=D=0;F=H={};O=false}w.css("overflow","hidden");if(F.transitionOut=="elastic"){a=V();var X=K.position();c={top:X.top,left:X.left,width:K.width(),height:K.height()};if(F.opacity){c.opacity=1}t.prop=1;A(t).animate({prop:0},{duration:F.speedOut,easing:F.easingOut,step:G,complete:W})}else{K.fadeOut(F.transitionOut=="none"?0:F.speedOut,W)}};A.fancybox.resize=function(){var X,W;if(O||K.is(":hidden")){return}O=true;X=w.wrapInner("<div style='overflow:auto'></div>").children();W=X.height();K.css({height:W+(F.padding*2)+j});w.css({height:W});X.replaceWith(X.children());A.fancybox.center()};A.fancybox.center=function(){O=true;var W=E(),X=F.margin,Y={};Y.top=W[3]+((W[1]-((K.height()-j)+(C*2)))*0.5);Y.left=W[2]+((W[0]-(K.width()+(C*2)))*0.5);Y.top=Math.max(W[3]+X,Y.top);Y.left=Math.max(W[2]+X,Y.left);K.css(Y);O=false};A.fn.fancybox.defaults={padding:10,margin:20,opacity:false,modal:false,cyclic:false,scrolling:"auto",width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:0.3,overlayColor:"#666",titleShow:true,titlePosition:"outside",titleFormat:null,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",easingIn:"swing",easingOut:"swing",showCloseButton:true,showNavArrows:true,enableEscapeButton:true,onStart:null,onCancel:null,onComplete:null,onCleanup:null,onClosed:null};A(document).ready(function(){B()})})(jQuery);