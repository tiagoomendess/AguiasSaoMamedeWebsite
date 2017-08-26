<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class SettingsController extends Controller
{
    public function index() {

        $settings = Config::get('settings');

        return view('painel.settings', ['settings' => $settings]);

    }

    public function update(Request $request) {
        return redirect(route('settings'));
    }


    /**
     * Gets the name of the setting key
    **/
    public static function getName($key) {


        switch ($key) {

            case 'website_name':
                return 'Nome do site';

            case 'closed':
                return 'Fechado';

            case 'pannel_name':
                return 'Nome do painel';

            case 'social_logins_enabled':
                return 'Logins sociais';

            case 'logins_enabled':
                return 'Logins';

            case 'registration_enabled':
                return 'Registos';

            case 'pannel_results_per_page':
                return 'Resultados por pagina no painel';

            case 'members_proposals_enabled':
                return 'Propostas de sócio';

            case 'online_share_payment_enabled':
                return 'Pagamentos online';

            case 'front_end_maintenence':
                return 'Website em manutenção';

            case 'back_end_maintenence':
                return 'Painel em manutenção';

            default:
                return 'Definição desconhecida';
        }
    }
}
