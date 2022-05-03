<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\SharedHelpers\ConvertorJSON;


class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [ 'description', 'value', 'updated_at' ];


    protected $how_to_display_settings_properties = [
        /*
                Здесь настраивать
            в каком порядке свойства будут отображены на экране пользователя (админа),
            поля массива повторяют свойства таблицы settings/name
        */
        'site_is_closed',
        'site_name_part_1',
        'site_name_part_2',
        'keywords',
        'description',
        'sum_dictionaries_in_one_level',
        'scale_stars_for_one_dictionary',
        'passing_score_from_100',
        'sending_a_message_during_registration',
        'is_password_reset_enabled',
    ];

    public function getListSettingsForClient(){
        $settings = $this::get();

        $arr = [];


        


        foreach( $settings as $item ){



            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $interval_json = json_decode( $item->interval );
            //$convertor = new ConvertorJSON();
            //$interval_json = $convertor->from_json_to_array( $item->interval );


            $interval = [];

            if( !is_null($interval_json) ){

                if( is_object( $interval_json ) ){
                    $interval = [ $interval_json->from, $interval_json->to ];
                }else if( is_array( $interval_json ) ){
                    for( $i = 0; $i < count( $interval_json ); $i++ ){
                        array_push( $interval, $interval_json[$i] );
                    };

                };

            };
            $arr[ $item->name ] = [
                'value' =>          $item->value,
                'description' =>    $item->description,
				'interval' =>       $interval,
            ];
        };

        $result = [];
        for( $i = 0; $i < count( $this->how_to_display_settings_properties ); $i++ ){
            $name = $this->how_to_display_settings_properties[ $i ];

            if( isset( $arr[ $name ] ) ){
                $result[ $name ] = [
                    'value' =>          $arr[ $name ]['value'],
                    'description' =>    $arr[ $name ]['description'],
                    'interval' =>       $arr[ $name ]['interval'],
                ];
            };
        };

        return $result;

    }

    public function setNewSettings( $params ){
        foreach(  $params as $k => $v ){
            $setting = $this::where('name', '=', $k )->first();
            if( $setting !== null ){
                $id = $setting['id'];
                $setting_changed = $this::find( $id );
                $setting_changed->value = (string)$v;
                $setting_changed->save();
            };
        };
    }

    public function setDefaultSettings(){
        $settings = $this->get();
        foreach( $settings as $item ){
            $id = $item['id'];
            $setting = $this::find( $id );
            $setting->value = $setting->default_value;
            $setting->save();
        };
        
    }

    private function get_a_list_of_value_types(){
        return [
            'text' =>           'text',
            'number' =>         'number',
            'radio' =>          'radio',
            // 'checkbox' =>    'checkbox',  // не удаляь !!!!!!, это на будущее
        ];
    }


    public function get_a_value_for_a_single_setting( $name ){

        $setting = $this::where('name', '=', $name )->first();
        $list_of_types = $this->get_a_list_of_value_types();

        $result = null;

        if( isset($setting) ){






            


            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $interval = json_decode( $setting->interval );

            //$convertor = new ConvertorJSON();
            //$interval = $convertor->from_json_to_array( $setting->interval );





            $value = $setting->value;

            $type_of_value = $this->getTypeOfSetting( ['interval' => $interval ] );

            if( $type_of_value === $list_of_types['text'] ){
                $result = (string) $value;

            }else if( $type_of_value === $list_of_types['number'] ){
                $result = (int) $value;

            }else if( $type_of_value === $list_of_types['radio'] ){
                
                if( $value === 'true' ){
                    $result = true;

                }else if( $value === 'false' ){
                    $result = false;
                };
            };

        };

        return $result;
    }

    private function getTypeOfSetting( $params ){

        $interval = $params['interval'];

        $value_type = $this->get_a_list_of_value_types();

        $result = null;

        if( $interval === '' || $interval === null ){
            $result = $value_type['text'];

        }else{
            if( isset( $interval->from ) && isset( $interval->to ) ){
                $result = $value_type['number'];
            }else{
                if( count( $interval ) === 2 ){
                    if( isset( $interval[0] ) && isset( $interval[1] ) ){
                        $item_0 = ($interval[0] === 'false' || $interval[0] === 'true');
                        $item_1 = ($interval[1] === 'false' || $interval[1] === 'true');
                        if( $item_0 && $item_1 ){
                            $result = $value_type['radio'];
                        };
                    };
                }else{

                    /*
                        новые настройки добавлять сюда
                    */
                };
            };
        };

        return $result;

    }



}
