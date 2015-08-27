<?php
namespace Tev\Tev\Configuration\Provider;

/**
 * Configuration provider to insert a Google Map into TCA forms, and allow
 * users to drag a marker around and store its lat/lng value.
 *
 * Usage (in TCA):
 *
 *     'map' => [
 *         'exclude' => 1,
 *         'label' => 'Drag the marker to set the latidue and longitude',
 *         'config' => [
 *             'type' => 'user',
 *             'userFunc' => 'Tev\\Tev\\Configuration\\Provider\\MapConfigurationProvider->run',
 *             'parameters' => [
 *                 'map_field' => 'map', // Name of this field
 *                 'lat_field' => 'lat', // Name of lat field to save value in (required)
 *                 'lng_field' => 'lng', // Name of lng field to save value in (required)
 *                 'api_key' => 'xxxxxxxxxxxxxxxx' // Google Maps API key (required)
 *              ]
 *          ]
 *     ]
 */
class MapConfigurationProvider
{
    /**
     * Default latitude when none is set.
     */
    const MAP_DEFAULT_LAT = 51.5010225124716;

    /**
     * Default longitude when none is set.
     */
    const MAP_DEFAULT_LNG = -0.14241416360471248;

    /**
     * Whether or not the Google Maps API has aleady been included.
     *
     * @var boolean
     */
    private static $libIncluded = false;

    /**
     * Run the configuration provider.
     *
     * @param  array                              $data Configuration data
     * @param  \TYPO3\CMS\Backend\Form\FormEngine $form Form object
     * @return string                                   Field output
     */
    public function run($data, $form)
    {
        $mapField = $this->getParameter('map_field', $data);
        $latField = $this->getParameter('lat_field', $data);
        $lngField = $this->getParameter('lng_field', $data);
        $lat = isset($data['row'][$latField]) ? $data['row'][$latField] : null;
        $lng = isset($data['row'][$lngField]) ? $data['row'][$lngField] : null;

        if (!$lat || !$lng) {
            $lat = self::MAP_DEFAULT_LAT;
            $lng = self::MAP_DEFAULT_LNG;
        }

        $mapId = $this->getMapId();

        $out  = $this->appendGoogleMaps($data['parameters']['api_key']);
        $out .= $this->appendMapContainer($mapId);
        $out .= $this->appendMapSetup(
            $mapId,
            $lat,
            $lng,
            $this->getFieldName($mapField, $latField, $data['itemFormElName']),
            $this->getFieldName($mapField, $lngField, $data['itemFormElName'])
        );

        return $out;
    }

    /**
     * Get the JS map ID.
     *
     * @return string
     */
    private function getMapId()
    {
        return 'tev-tca-google-map-' . uniqid();
    }

    /**
     * Append the Google Maps JS API to the page.
     *
     * Will only be appended once.
     *
     * @param  string $apiKey Google Maps API key
     * @return string
     */
    private function appendGoogleMaps($apiKey)
    {
        if (!self::$libIncluded) {
            self::$libIncluded = true;
            return "<script src=\"https://maps.googleapis.com/maps/api/js?key={$apiKey}\"></script>";
        }

        return '';
    }

    /**
     * Append the containing map element to the page.
     *
     * @param  string $id Element ID
     * @return string
     */
    private function appendMapContainer($id)
    {
        return '<div id="' . $id . '" style="width: 100%; height: 350px;"></div>';
    }

    /**
     * Get another field name using a base name as a comparison.
     *
     * @param  string $base      Base field name
     * @param  string $search    Full field name to search for
     * @param  string $fullField Base full field name
     * @return string
     */
    private function getFieldName($base, $search, $fullField)
    {
        return str_replace('[' . $base . ']', '[' . $search . ']', $fullField);
    }

    /**
     * Get a configured parameter value.
     *
     * @param  string $key  Parameter name
     * @param  array  $data Configuration data
     * @return mixed        Value, or null if not set
     */
    private function getParameter($key, $data)
    {
        if (isset($data['parameters'][$key])) {
            return $data['parameters'][$key];
        } elseif (isset($data['fieldConf']['config']['arguments']) &&
            isset($data['fieldConf']['config']['arguments'][$key])
        ) {
           return $data['fieldConf']['config']['arguments'][$key];
        }

        return null;
    }

    /**
     * Append the map setup script to the page.
     *
     * @param  string $id       Map element ID
     * @param  string $lat      Lat value
     * @param  string $lng      Lng value
     * @param  string $latField Target lat field name
     * @param  string $lngField Target lng field name
     * @return string
     */
    private function appendMapSetup($id, $lat, $lng, $latField, $lngField)
    {
        return "
            <script>
                ;(function (j, g) {
                    var mapEl = j('#{$id}')
                      , pos = {
                            lat: {$lat}
                          , lng: {$lng}
                        }
                      , map = new g.maps.Map(mapEl[0], {
                            zoom: 12
                          , center: pos
                          , mapTypeControl: false
                        })
                      , marker = new g.maps.Marker({
                            position: pos
                          , map: map
                          , draggable: true
                        })

                    g.maps.event.addListener(marker, 'dragend', function (e) {
                        var p = marker.getPosition()
                        j('input[name=\"{$latField}_hr\"]').first().val(p.lat())
                        j('input[name=\"{$lngField}_hr\"]').first().val(p.lng())
                        j('input[name=\"{$latField}\"]').first().val(p.lat())
                        j('input[name=\"{$lngField}\"]').first().val(p.lng())
                    })
                })(window.TYPO3.jQuery, window.google);
            </script>
        ";
    }
}
