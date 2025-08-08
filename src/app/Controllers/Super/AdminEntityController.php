<?php

namespace App\Controllers\Super;

use App\Core\Template;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class AdminEntityController
{
    public function handle(Template $template)
    {
        $template->apply();
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
        header('Location: admin_entities/provinces/index.php');
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
        header('Location: admin_entities/provinces/index.php');
    }

    public function deleteProvince($template)
    {
        $id = $_GET['id'] ?? null;
        ProvinceUtils::delete($id);
        header('Location: admin_entities/provinces/index.php');
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
        header('Location: admin_entities/municipalities/index.php');
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
        header('Location: admin_entities/municipalities/index.php');
    }

    public function deleteMunicipality($template)
    {
        $id = $_GET['id'] ?? null;
        MunicipalityUtils::delete($id);
        header('Location: admin_entities/municipalities/index.php');
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
        header('Location: admin_entities/neighborhoods/index.php');
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
        header('Location: admin_entities/neighborhoods/index.php');
    }

    public function deleteNeighborhood($template)
    {
        $id = $_GET['id'] ?? null;
        NeighborhoodUtils::delete($id);
        header('Location: admin_entities/neighborhoods/index.php');
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
        header('Location: admin_entities/labels/index.php');
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
        header('Location: admin_entities/labels/index.php');
    }

    public function deleteLabel($template)
    {
        $id = $_GET['id'] ?? null;
        LabelUtils::delete($id);
        header('Location: admin_entities/labels/index.php');
    }
}
