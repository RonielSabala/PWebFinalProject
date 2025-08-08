<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\UserUtils;
use App\Utils\Entities\RoleUtils;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class EntityController
{
    public function handle(Template $template)
    {
        $data = [];
        $route = $template::$viewPath;

        if (str_contains($route, 'users')) {
            $data = self::handle_users();
        } elseif (str_contains($route, 'provinces')) {
            $data = self::handle_provinces();
        } elseif (str_contains($route, 'municipalities')) {
            $data = self::handle_municipalities();
        } elseif (str_contains($route, 'neighborhoods')) {
            $data = self::handle_neighborhoods();
        } elseif (str_contains($route, 'labels')) {
            $data = self::handle_labels();
        }

        $template->apply($data);
    }

    public function handle_users()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];
            RoleUtils::clearUserRoles($userId);
            RoleUtils::assignUserRole($userId, $roleId);
        }

        $users = UserUtils::getAll();
        return ['users' => $users];
    }

    public function handle_provinces()
    {
        $provinces = ProvinceUtils::getAll();
        return ['provinces' => $provinces];
    }

    public function handle_municipalities()
    {
        $provinces = ProvinceUtils::getAll();
        $municipalities = MunicipalityUtils::getAll();
        return [
            'provinces' => $provinces,
            'municipalities' => $municipalities,
        ];
    }

    public function handle_neighborhoods()
    {
        $municipalities = MunicipalityUtils::getAll();
        $neighborhoods = NeighborhoodUtils::getAll();
        return [
            'municipalities' => $municipalities,
            'neighborhoods' => $neighborhoods,
        ];
    }

    public function handle_labels()
    {
        $labels = LabelUtils::getAll();
        return ['labels' => $labels];
    }

    // Provincias
    public function listProvinces($template)
    {
        $provinces = ProvinceUtils::getAll();
        $template->apply(['provinces' => $provinces]);
    }

    public function createProvinceForm($template)
    {
        $template->apply();
    }

    public function storeProvince($template)
    {
        ProvinceUtils::create($_POST);
        header('Location: admin_entities/provinces/home.php');
    }

    public function editProvinceForm($template)
    {
        $id = $_GET['id'] ?? null;
        $province = ProvinceUtils::getById($id);
        $template->apply(['province' => $province]);
    }

    public function updateProvince($template)
    {
        ProvinceUtils::update($_POST['id'], $_POST);
        header('Location: admin_entities/provinces/home.php');
    }

    public function deleteProvince($template)
    {
        $id = $_GET['id'] ?? null;
        ProvinceUtils::delete($id);
        header('Location: admin_entities/provinces/home.php');
    }

    // Municipios
    public function listMunicipalities($template)
    {
        $municipalities = MunicipalityUtils::getAll();
        $provinces = ProvinceUtils::getAll(); // Por si quieres mostrar nombre provincia en la vista
        $template->apply([
            'municipalities' => $municipalities,
            'provinces' => $provinces
        ]);
    }

    public function createMunicipalityForm($template)
    {
        // Para crear un municipio es útil mostrar la lista de provincias (relación)
        $provinces = ProvinceUtils::getAll();
        $template->apply(['provinces' => $provinces]);
    }

    public function storeMunicipality($template)
    {
        $municipalityName = $_GET['municipalityName'] ?? null;
        $provinceId = $_GET['provinceId'] ?? null;
        MunicipalityUtils::create($municipalityName, $provinceId);
        header('Location: admin_entities/municipalities/home.php');
    }

    public function editMunicipalityForm($template)
    {
        $id = $_GET['id'] ?? null;
        $municipality = MunicipalityUtils::getById($id);
        $provinces = ProvinceUtils::getAll();
        $template->apply([
            'municipality' => $municipality,
            'provinces' => $provinces
        ]);
    }

    public function updateMunicipality($template)
    {
        $id = $_GET['id'] ?? null;
        $municipalityName = $_GET['municipalityName'] ?? null;
        $provinceId = $_GET['provinceId'] ?? null;
        MunicipalityUtils::update($id, $municipalityName, $provinceId);
        header('Location: admin_entities/municipalities/home.php');
    }

    public function deleteMunicipality($template)
    {
        $id = $_GET['id'] ?? null;
        MunicipalityUtils::delete($id);
        header('Location: admin_entities/municipalities/home.php');
    }

    // Barrios (Neighborhoods)
    public function listNeighborhoods($template)
    {
        $neighborhoods = NeighborhoodUtils::getAll();
        $municipalities = MunicipalityUtils::getAll();
        $template->apply([
            'neighborhoods' => $neighborhoods,
            'municipalities' => $municipalities
        ]);
    }

    public function createNeighborhoodForm($template)
    {
        $municipalities = MunicipalityUtils::getAll();
        $template->apply([
            'municipalities' => $municipalities
        ]);
    }

    public function storeNeighborhood($template)
    {
        $neighborhoodName = $_GET['neighborhoodName'] ?? null;
        $municipalityId = $_GET['municipalityId'] ?? null;
        NeighborhoodUtils::create($neighborhoodName, $municipalityId);
        header('Location: admin_entities/neighborhoods/home.php');
    }

    public function editNeighborhoodForm($template)
    {
        $id = $_GET['id'] ?? null;
        $neighborhood = NeighborhoodUtils::getById($id);
        $municipalities = MunicipalityUtils::getAll();
        $template->apply([
            'neighborhood' => $neighborhood,
            'municipalities' => $municipalities
        ]);
    }

    public function updateNeighborhood($template)
    {
        $id = $_POST['id'] ?? null;
        $neighborhoodName = $_POST['neighborhoodName'] ?? null;
        $municipalityId = $_POST['municipalityId'] ?? null;
        NeighborhoodUtils::update($id, $neighborhoodName, $municipalityId);
        header('Location: admin_entities/neighborhoods/home.php');
    }

    public function deleteNeighborhood($template)
    {
        $id = $_GET['id'] ?? null;
        NeighborhoodUtils::delete($id);
        header('Location: admin_entities/neighborhoods/home.php');
    }

    // Labels
    public function listLabels($template)
    {
        $labels = LabelUtils::getAll();
        $template->apply(['labels' => $labels]);
    }

    public function createLabelForm($template)
    {
        $template->apply();
    }

    public function storeLabel($template)
    {
        LabelUtils::create($_POST);
        header('Location: admin_entities/labels/home.php');
    }

    public function editLabelForm($template)
    {
        $id = $_GET['id'] ?? null;
        $label = LabelUtils::getById($id);
        $template->apply(['label' => $label]);
    }

    public function updateLabel($template)
    {
        $id = $_GET['id'] ?? null;
        $labelName = $_GET['labelName'] ?? null;
        LabelUtils::update($labelName, $id);
        header('Location: admin_entities/labels/home.php');
    }

    public function deleteLabel($template)
    {
        $id = $_GET['id'] ?? null;
        LabelUtils::delete($id);
        header('Location: admin_entities/labels/home.php');
    }
}
