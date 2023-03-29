/**
 * Created by akim on 02.06.14.
 */

mapsUtil = function (inputOptions) {
    var self = this,
        geoObjectsCache      = {},
        cacheMap             = {},
        geoIdsCache          = {},
        balloon              = null,
        mapObject            = null,
        mapProvider          = null,
        tileConverter        = new TileCoordConverter(),
        loadingIndicator     = null,
        geoObjectsCollection = null,
        options = {
            "type"                 : 'yandex#map',
            "objectId"             : null,
            "lat"                  : 43.253509,
            "lon"                  : 76.966092,
            "readOnly"             : false,
            "zoom"                 : 12,
            "latContainer"         : $('#geo_lat'),
            "lonContainer"         : $('#geo_lon'),
            "zoomContainer"        : $('#geo_zoom'),
            "mapTypeContainer"     : $("#geo_map_type"),
            "removeMarkerButton"   : $('.close_button'),
            "mapContainerId"       : 'map_canvas',
            "modalInitiatorElement": false,
            "placemark"            : {
                'hintContent': '',
                'iconContent': '',
                "preset"     : 'islands#blueStretchyIcon'
            },
            "collection"           : {
                "url"       : false,
                "placemark" : {},
                "useCache"  : true,
                "searchArgs": '' //string
            },
            "balloonHtmlUrl"       : false,
            "showStartPlacemark"   : true,
            "onBoundsChange"       : null,
            "showSearchArgsInUrl"  : false
        }

    options = $.extend(true, options, inputOptions);

    this.initYandexMap = function (callback) {
        $.getScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU&mode=release', function (data, textStatus, jqxhr) {
            try {
                ymaps.ready(function () {
                    var yandexMap = new ymaps.Map(
                            options.mapContainerId,
                            {
                                center  : [options.lat, options.lon],
                                zoom    : options.zoom,
                                controls: ["zoomControl", "typeSelector", "fullscreenControl", "geolocationControl"],
                                type    : self.getActualMapType(options.type)
                            },
                            {
                                avoidFractionalZoom:false
                            }
                        ),
                        startPlacemark = new ymaps.Placemark(
                            yandexMap.getCenter(),
                            {
                                hintContent: options.placemark.hintContent,
                                iconContent: options.placemark.iconContent,
                                objectId   : options.objectId
                            },
                            options.placemark
                        );

                    geoObjectsCollection = new ymaps.GeoObjectCollection();
                    yandexMap.geoObjects.add(geoObjectsCollection);

                    mapObject = yandexMap;
                    mapProvider = ymaps;

                    if (typeof (publicSchemeHost) == 'undefined') {
                        console.log('need to define publicSchemeHost');
                        publicSchemeHost = null;
                    }

                    loadingIndicator = $('<div class="loading-indicator" ' +
                        'style="display:none;position:absolute;top:16px;left:50px;z-index: 100;">' +
                        '<img src="' + publicSchemeHost + '/js/jquery/loading.gif"/></div>');
                    $('#'+options.mapContainerId).prepend(loadingIndicator);

                    if (options.collection.placemark.preset == 'old-search') {
                        options.collection.placemark = {
                            iconContentLayout: mapProvider.templateLayoutFactory.createClass(
                                '<div class="placemark-content" style="width:{{properties.contentWith}} ">' +
                                    '{{properties.iconContent}}</div>'
                            ),
                            iconLayout       : 'default#imageWithContent',
                            iconContentOffset: [-2, 5],
                            iconImageHref    : publicSchemeHost + '/js/map/pointer-2.png',
                            iconImageSize    : [40, 30],
                            iconOffset       : [-18, -30],
                            iconShape        : {type: 'Circle', coordinates: [20, 15], radius: 20}
                        }
                    }

                    yandexMap.geoObjects.events.add('add', function () {
                        options.removeMarkerButton.show();
                    });

                    yandexMap.geoObjects.events.add('remove', function () {
                        options.removeMarkerButton.hide();
                    });

                    options.removeMarkerButton.click(function () {
                        self.removeMarkers(yandexMap, startPlacemark);
                    });

                    if (options.showStartPlacemark && (!options.latContainer.length || options.lonContainer.val())) {
                        startPlacemark.geometry.setCoordinates(
                            [options.lat, options.lon],
                            options.zoom
                        );
                        startPlacemark.properties.set('byUser', true);
                        yandexMap.geoObjects.add(startPlacemark);
                    }

                    if (!options.readOnly) {
                        yandexMap.events.add('click', function (e) {
                            var coords = e.get('coords');
                            startPlacemark.geometry.setCoordinates(coords);
                            startPlacemark.properties.set('byUser', true);
                            self.setMapCoordinates(coords[0], coords[1], yandexMap.getZoom(), yandexMap.getType());
                            yandexMap.geoObjects.add(startPlacemark);
                        });
                    }

                    self.setRegionClickHandler(yandexMap);
                    self.setStreetInputHandler(yandexMap, startPlacemark);

                    if (options.modalInitiatorElement) {
                        self.initModalMap()
                    }

                    if (options.collection.url) {
                        self.appendGeoCollection(yandexMap, ymaps);
                    }

                    if (options.balloonHtmlUrl) {
                        startPlacemark.events.add('click', function (e) {
                            self.showBalloon(startPlacemark.geometry.getCoordinates(), options.objectId, yandexMap, ymaps);
                        });
                    }

                    if (options.onBoundsChange) {
                        mapObject.events.add('boundschange', function (event) {
                            options.onBoundsChange(event);
                        });
                    }

                    if (typeof (callback) != 'undefined') {
                        callback(yandexMap, self);
                    }
                });
            } catch (e) {
                console.log(e.message);
            }
        });
    }

    this.loadObjects = function (tilesBounds, zoom, callback) {
        if (!options.collection.url) {
            console.log('collection url not provided');
            return false;
        }

        loadingIndicator.show();

        $.ajax({
            data    : $.param({tilesBounds: tilesBounds}) + '&' + $.param({zoom: zoom}) + '&' + options.collection.searchArgs,
            async   : true,
            dataType: 'json',
            type    : 'POST',
            url     : options.collection.url,
            success : function (response) {
                if (response['status'] == 'ok' && typeof (response['tiles']) != 'undefined') {
                    self.setObjectsCollection(response['tiles'], zoom);
                } else {
                    console.log('wrong response');
                }

                if (typeof (callback) == 'function') {
                    callback();
                }

                if (options.showSearchArgsInUrl && typeof (history.pushState) != 'undefined') {
                    var center = mapObject.getCenter();
                    history.pushState(
                        '',
                        '',
                       window.location.pathname +
                            '?' + options.collection.searchArgs + '&' + $.param({zoom: zoom}) +
                            '&lat=' + center[0] + '&lon=' + center[1]
                    );
                }

                loadingIndicator.hide();
            }
        });
    }

    this.appendGeoCollection = function () {
        var tileBounds = self.getBoundsTiles(mapObject.getBounds(), options.zoom);

        self.loadObjects(
            tileBounds,
            options.zoom
        );

        mapObject.events.add('boundschange', function (event) {
            var tilesToLoad  = [],
                tileBounds   = {},
                doRequest    = false,
                z            = Math.round(event.get('newZoom')),
                visibleTiles = self.getBoundsTiles(event.get('newBounds'), z);

            for (var x = visibleTiles['max']['x']; x >= visibleTiles['min']['x']; x--) {
                for (var y = visibleTiles['max']['y']; y >= visibleTiles['min']['y']; y--) {
                    if (!self.issetKey(cacheMap, z) || !self.issetKey(cacheMap[z], x)
                        || !self.issetKey(cacheMap[z][x], y)) {
                        doRequest = true;
                        tilesToLoad.push({'x': x, 'y': y});
                    }
                }
            }

            if (doRequest) {
                tileBounds = {
                    'max': tilesToLoad[0],
                    'min': tilesToLoad[tilesToLoad.length - 1]
                };

                self.loadObjects(
                    tileBounds,
                    z,
                    function () {
                        for (x = visibleTiles['max']['x']; x >= visibleTiles['min']['x']; x--) {
                            for (y = visibleTiles['max']['y']; y >= visibleTiles['min']['y']; y--) {
                                self.issetAndCreate(cacheMap, z, {});
                                self.issetAndCreate(cacheMap[z], x, {});
                                self.issetAndCreate(cacheMap[z][x], y, {});
                            }
                        }
                    }
                );
            } else {
                if (z != options.zoom) {
                    self.setObjectsCollectionFromCache(z);
                }
            }
        });
    }

    this.setObjectsCollection = function (tiles, zoom) {
        var oldZoom = null;
        if (options.zoom != zoom) {
            oldZoom           = options.zoom;
            options.zoom      = zoom;
            geoIdsCache[zoom] = {};
            if (typeof (geoObjectsCache[zoom]) != 'undefined') {
                tiles = $.extend(true, geoObjectsCache[zoom], tiles);
            }
        }

        $.each(tiles, function (i, tile) {
            self.issetAndCreate(geoObjectsCache, tile['z'], {});
            geoObjectsCache[tile['z']][i] = tile;
            self.issetAndCreate(geoIdsCache, tile['z'], {});

            $.each(tile['objects'], function (i, object) {
                if (!self.issetKey(geoIdsCache[zoom], i + '_' + object['nb'])) {
                    if (!self.issetKey(geoIdsCache, oldZoom) ||
                        !self.issetKey(geoIdsCache[oldZoom], i + '_' + object['nb'])) {
                        geoObjectsCollection.add(self.createPlacemark(object, i));
                    }
                    geoIdsCache[tile['z']][i + '_' + object['nb']] = object['nb'];
                }
            });
        });

        if (oldZoom != null) {
            self.cleanCollection(zoom, oldZoom);
        }

    }

    this.cleanCollection = function(newZoom, oldZoom){
        var idsToDelete     = self.array_diff_key(geoIdsCache[oldZoom], geoIdsCache[newZoom]),
            objectsToDelete = [];

        geoObjectsCollection.each(function (object) {
            if (typeof (idsToDelete
                [object.properties.get('objectId') + '_' + object.properties.get('nbObjects')]) != 'undefined') {
                objectsToDelete.push(object);
            }
        });

        for (var i = 0, l = objectsToDelete.length; i < l; i++) {
            geoObjectsCollection.remove(objectsToDelete[i]);
        }
    }

    this.array_diff_key = function (arr1) {
        var argl = arguments.length,
            retArr = {},
            k1 = '',
            i = 1,
            k = '',
            arr = {};

        arr1keys: for (k1 in arr1) {
            for (i = 1; i < argl; i++) {
                arr = arguments[i];
                for (k in arr) {
                    if (k === k1) {
                        continue arr1keys;
                    }
                }
                retArr[k1] = arr1[k1];
            }
        }

        return retArr;
    }

    this.getActualMapType = function(mapType)
    {
        var avalableTypes = [
            'yandex#map', 'yandex#satellite', 'yandex#hybrid', 'yandex#publicMap',  'yandex#publicMapHybrid'
        ];

        if (mapType == 'road') {
            mapType = 'yandex#map';
        } else if (mapType == 'hybrid') {
            mapType = 'yandex#hybrid';
        }

        var isValid = false;
        $.each(avalableTypes, function(i, v) {
            if (v == mapType) {
                isValid = true;
            }
        });

        if (!isValid) {
            mapType = 'yandex#map';
        }

        return mapType;
    }

    this.issetAndCreate = function(array, key, value)
    {
        if (typeof (array[key]) == 'undefined') {
            array[key] = value;
        }
    }

    this.issetKey = function(array, key)
    {
        if (typeof (array[key]) == 'undefined') {
            return false;
        }

        return true;
    }

    this.getBoundsTiles = function(bounds, z)
    {
        var ii       = 0,
            tiles    = [],
            tileSize = 256,
            blockNum = {x: 0, y: 0},
            size     = mapObject.container.getSize(),
            zeroTile = tileConverter.getTileCoordinate(bounds[1][0], bounds[0][1], z);

        blockNum.x = Math.floor(size[0]/tileSize)+2;
        blockNum.y = Math.floor(size[1]/tileSize)+2;

        for (var i = zeroTile.x; i < zeroTile.x + blockNum.x; i++) {
            for (var j = zeroTile.y; j < zeroTile.y + blockNum.y; j++) {
                tiles[ii] = [i, j, (i - zeroTile.x) * tileSize, (j - zeroTile.y) * tileSize];
                ii++;
            }
        }

        return {
            'min': {
                'x': tiles[0][0],
                'y': tiles[0][1]
            },
            'max': {
                'x': tiles[tiles.length - 1][0],
                'y': tiles[tiles.length - 1][1]
            }
        }
    }

    this.setObjectsCollectionFromCache = function(zoom)
    {
        if (typeof (geoObjectsCache[zoom]) != 'undefined') {
            self.setObjectsCollection(geoObjectsCache[zoom], zoom);
        }
    }

    this.initModalMap = function () {
        options.modalInitiatorElement.fancybox({
            href          : '#' + options.mapContainerId,
            padding       : 5,
            autoDimensions: true,
            onStart       : function () {
                $('#' + options.mapContainerId).show();
            },
            onCleanup     : function () {
                $('#' + options.mapContainerId).hide();
            }
        });
        options.modalInitiatorElement.show();
    }

    this.setMapCoordinates = function (latitude, longitude, zoom, type) {
        options.latContainer.val(latitude);
        options.lonContainer.val(longitude);
        options.zoomContainer.val(zoom);
        options.mapTypeContainer.val(type);
    }

    this.setRegionClickHandler = function (map) {
        $('#map_geo_id_1, #map_geo_id_2, #map_geo_id_3, #map_geo_id_4').click(function () {
            var geo = $(':selected', this);
            if (geo.attr('la') && geo.attr('lo')) {
                map.setCenter([geo.attr('la'), geo.attr('lo')], geo.attr('z'));
                map.setType(self.getActualMapType(geo.attr('t')));
            }
        });
    }

    this.setStreetInputHandler = function (map, startPlacemark) {
        $('#map_street, #map_house_num, #map_corner_street').change(function () {
            var city         = $('#map_geo_id_1').find(':selected').text(),
                street       = $('#map_street').val(),
                house        = $('#map_house_num').val(),
                cornerStreet = $('#map_corner_street').val(),
                request      = city ? city + ' ' : '',
                result;

            if (startPlacemark.properties.get('byUser', false)) {
                return true;
            }

            if (street && house) {
                request += street + ' дом ' + house;
            } else {
                if (street && cornerStreet) {
                    request += 'угол ' + street + ' ' + cornerStreet;
                } else {
                    request += street || cornerStreet;
                }
            }

            result = ymaps
                .geoQuery(ymaps.geocode(request.replace(/\(.+?\)/ig, ''), {'boundedBy' : map.getBounds()}))
                .searchInside(map);

            result.then(function () {
                var
                    resultObject = result.get(0),
                    coords = resultObject ? resultObject.geometry.getCoordinates() : null;

                if (coords) {
                    startPlacemark.geometry.setCoordinates(coords);
                    self.setMapCoordinates(coords[0], coords[1], map.getZoom(), map.getType());
                    map.geoObjects.add(startPlacemark);
                    map.setCenter(
                        coords,
                        map.getZoom(),
                        {'duration': 300}
                    );
                }
            });
        });
    }

    this.setCenter = function(lat, lon, zoom, type) {
        try {
            mapObject.setCenter([lat, lon], zoom);
            if (type) {
                mapObject.setType(self.getActualMapType(type));
            }
        } catch (e) {
            console.log(e);
        }
    }

    this.reloadMap = function () {
        cacheMap        = {};
        geoIdsCache     = {};
        geoObjectsCache = {};
        geoObjectsCollection.removeAll();
        self.loadObjects(self.getBoundsTiles(mapObject.getBounds(), mapObject.getZoom()), mapObject.getZoom());
    }

    this.removeMarkers = function (map, startPlacemark) {
        map.geoObjects.removeAll();
        startPlacemark.properties.set('byUser', false);
        self.setMapCoordinates('', '', '', '');
    }

    this.setCollectionSearchArgs = function (formData) {
        var clearParams = [];
        $(formData).each(function (i, d) {
            if (d.value != '') {
                clearParams.push(d);
            }
        });

        options.collection.searchArgs = $.param(clearParams);
    }

    this.createPlacemark = function (geoObject, objectId) {
        var clusterOptions = {
                10  : {iconContentOffset: [2, 6], iconImageSize: [33, 33]},
                100 : {iconContentOffset: [7, 11], iconImageSize: [42, 42]},
                1000: {iconContentOffset: [10, 11], iconImageSize: [50, 42]}
            },
            clusterKey  = 10,
            placemark   = null,
            contentWith = 0;

        if (typeof (geoObject['nb']) != 'undefined' && geoObject['nb'] > 1) {
            // кластер
            if (geoObject['nb'] < 100) {
                clusterKey = 10;
            } else if (geoObject['nb'] < 1000) {
                clusterKey = 100;
            } else if (geoObject['nb'] >= 1000) {
                clusterKey = 1000;
            }

            placemark = new mapProvider.Placemark(
                geoObject['coords'],
                {
                    objectId   : objectId,
                    iconContent: geoObject['nb'],
                    nbObjects  : geoObject['nb']
                },
                {
                    iconContentLayout: mapProvider.templateLayoutFactory.createClass(
                        '<div class="cluster-content">{{properties.iconContent}}</div>'
                    ),
                    iconLayout       : 'default#imageWithContent',
                    iconContentOffset: clusterOptions[clusterKey]['iconContentOffset'],
                    iconImageHref    : publicSchemeHost + '/js/map/cluster-gr.png',
                    iconImageSize    : clusterOptions[clusterKey]['iconImageSize'],
                    iconOffset       : [-10, -35],
                    iconShape        : {type: 'Circle', coordinates: [20, 15], radius: 20}
                }
            );
            placemark.events.add('click', function (e) {
                mapObject.setCenter(
                    e.get('target').geometry.getCoordinates(),
                    mapObject.getZoom() + 2,
                    {
                        'duration': 300
                    });
            });
        } else {
            if (typeof (geoObject['info']['price']) != 'undefined') {
                contentWith = geoObject['info']['price'].length*6 + 'px';
            }

            placemark = new mapProvider.Placemark(
                geoObject['coords'],
                {
                    nbObjects  : geoObject['nb'],
                    contentWith : contentWith,
                    objectId    : objectId,
                    iconContent : geoObject['info']['price'],
                    hintContent : (typeof (geoObject['info']['hint']) != 'undefined' ? geoObject['info']['hint'] : '')
                },
                options.objectId == objectId ? options.placemark : options.collection.placemark
            );
            placemark.events.add('click', function (e) {
                var objectId = e.get('target').properties.get("objectId");
                self.showBalloon(geoObject['coords'], objectId, mapObject, mapProvider);
            });
        }

        return placemark;
    }

    this.showBalloon = function (coords, objectId) {
        if (balloon && balloon.isOpen()) {
            balloon.close();
        }
        balloon = new mapProvider.Balloon(
             mapObject,
             {
                 'maxWidth': 500
             }
         );
        balloon.options.setParent(mapObject.options);
        balloon.setData('<div style="text-align: center; padding: 10px">'+
            '<img src="' + publicSchemeHost + '/js/jquery/loading.gif"/></div>');
        balloon.open(coords);

        $.get(options.balloonHtmlUrl, {"id": objectId}, function (html) {
            balloon.setData(html);
        })
    }

    this.getBounds = function () {
        return mapObject.getBounds();
    }
}

/**
 *  Преобразует координаты в тайлы
 *
 */
TileCoordConverter = function () {
    this.maxZoom            = 23;
    this.tileSize           = 256;
    this.pixelsPerLonDegree = [];
    this.pixelsPerLonRadian = [];
    this.numTiles           = [];
    this.bitmapOrigo        = [];
    this.c                  = 256;
    this.bc;
    this.Wa;

    this.p = function (x, y) {
        return {x: x, y: y};
    };

    this.fillInConstants = function () {
        this.bc = 2 * Math.PI;
        this.Wa = Math.PI / 180;

        for (z = 0; z < this.maxZoom; z++) {
            this.pixelsPerLonDegree[z] = this.c / 360;
            this.pixelsPerLonRadian[z] = this.c / this.bc;
            e                          = this.c / 2;
            this.bitmapOrigo[z]        = this.p(e, e);
            this.numTiles[z]           = this.c / 256;
            this.c                    *= 2;
        }
    };

    this.fillInConstants();

    this.getBitmapCoordinate = function (a, b, c) {
        ret   = this.p(0, 0);
        ret.x = Math.floor(this.bitmapOrigo[c].x + (b + 0.0001) * this.pixelsPerLonDegree[c]);
        e     = Math.sin(a * this.Wa);

        if (e > 0.9999) {
            e = 0.9999;
        }

        if (e < -0.9999) {
            e = -0.9999;
        }

        ret.y = Math.floor(this.bitmapOrigo[c].y - 0.5 * Math.log((1 + e) / (1 - e)) * (this.pixelsPerLonRadian[c]));

        if (ret.y < 0) {
            ret.y = 0;
        }

        return ret;
    };

    this.getTileCoordinate = function (a, b, c) {
        ret        = this.getBitmapCoordinate(a, b, c);
        ret.offset = {x: (ret.x % this.tileSize), y: (ret.y % this.tileSize)};
        ret.x      = this.normalizeTile(Math.floor(ret.x / this.tileSize), c);
        ret.y      = this.normalizeTile(Math.floor(ret.y / this.tileSize), c);
        return ret;
    };

    this.normalizeTile = function (a, z) {
        while (a < 0) {
            a += this.numTiles[z];
        }

        return a % this.numTiles[z];
    };
};