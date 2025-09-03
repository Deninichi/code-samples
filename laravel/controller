<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\Project\ArchitectNameOrSlug;
use App\Filters\Project\Beds;
use App\Filters\Project\Search;
use App\Filters\Project\BuildingHeight;
use App\Filters\Project\Cities;
use App\Filters\Project\ConstructionStatus;
use App\Filters\Project\CurrentPriceRange;
use App\Filters\Project\Deposit;
use App\Filters\Project\DeveloperName;
use App\Filters\Project\Districts;
use App\Filters\Project\InteriorSize;
use App\Filters\Project\LaunchDate;
use App\Filters\Project\LaunchPrice;
use App\Filters\Project\LaunchPsfAvg;
use App\Filters\Project\LockerPrice;
use App\Filters\Project\MaintenanceFees;
use App\Filters\Project\Name;
use App\Filters\Project\Neighbourhoods;
use App\Filters\Project\OccupancyDate;
use App\Filters\Project\ParkingPrice;
use App\Filters\Project\PricePerSqft;
use App\Filters\Project\SalesMarketingCompany;
use App\Filters\Project\SalesStatus;
use App\Filters\Project\Sort;
use App\Filters\Project\Storeys;
use App\Filters\Project\Suites;
use App\Filters\Project\Type;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\HasPaginationResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

/**
 * APIs for managing and retrieving real estate projects.
 *
 * These endpoints allow you to retrieve a list of projects or detailed information about a specific project.
 */
class ProjectController extends Controller
{
    use HasPaginationResponse;

    /**
     * List all projects
     *
     * Retrieve a list of all real estate projects with optional filters and pagination.
     *
     * @group Endpoints
     * @subgroup Projects
     *
     * @queryParam name string Filter by project name. Example: Aurora Hills
     * @queryParam city string Filter by city, con be comma-separated ID or name value. Example: 111,222,333
     * @queryParam district string Filter by district, con be comma-separated ID or name value. Example: 111,222,333
     * @queryParam neighbourhood string Filter by neighbourhood, con be comma-separated ID or name value. Example: 111,222,333
     * @queryParam sales_status string Filter by sales status. Example: selling
     * @queryParam construction_status string Filter by construction status. Example: under_construction
     * @queryParam type string Filter by building type. Example: Condominium
     * @queryParam occupancy_date_min string Minimum occupancy date (YYYY-MM-DD). Example: 2025-01-01
     * @queryParam occupancy_date_max string Maximum occupancy date (YYYY-MM-DD). Example: 2026-01-01
     * @queryParam launch_date_min string Minimum launch date (YYYY-MM-DD). Example: 2024-01-01
     * @queryParam launch_date_max string Maximum launch date (YYYY-MM-DD). Example: 2024-12-31
     * @queryParam launch_psf_avg_min numeric Minimum launch price per square foot average. Example: 1000
     * @queryParam launch_psf_avg_max numeric Maximum launch price per square foot average. Example: 2000
     * @queryParam launch_price_min numeric Minimum launch price. Example: 300000
     * @queryParam launch_price_max numeric Maximum launch price. Example: 900000
     * @queryParam price_per_sqft_min numeric Minimum price per square foot. Example: 1000
     * @queryParam price_per_sqft_max numeric Maximum price per square foot. Example: 2000
     * @queryParam current_price_min numeric Minimum current price. Example: 400000
     * @queryParam current_price_max numeric Maximum current price. Example: 800000
     * @queryParam interior_size_min numeric Minimum interior size. Example: 500
     * @queryParam interior_size_max numeric Maximum interior size. Example: 2000
     * @queryParam maintenance_fees_min numeric Minimum maintenance fees. Example: 0.5
     * @queryParam maintenance_fees_max numeric Maximum maintenance fees. Example: 1.5
     * @queryParam parking_price_min numeric Minimum parking price. Example: 20000
     * @queryParam parking_price_max numeric Maximum parking price. Example: 50000
     * @queryParam locker_price_min numeric Minimum locker price. Example: 2000
     * @queryParam locker_price_max numeric Maximum locker price. Example: 10000
     * @queryParam deposit_min numeric Minimum deposit. Example: 5
     * @queryParam deposit_max numeric Maximum deposit. Example: 20
     * @queryParam developer string Filter by developer name. Example: Tridel
     * @queryParam architect string Filter by architect name or slug. Example: KPMB
     * @queryParam sales_marketing_company string Filter by sales and marketing company. Example: Baker
     * @queryParam storeys_min integer Minimum number of storeys. Example: 10
     * @queryParam storeys_max integer Maximum number of storeys. Example: 40
     * @queryParam building_height_min numeric Minimum building height (meters). Example: 50
     * @queryParam building_height_max numeric Maximum building height (meters). Example: 150
     * @queryParam suites_min integer Minimum number of suites. Example: 100
     * @queryParam suites_max integer Maximum number of suites. Example: 300
     * @queryParam beds_min integer Minimum number of bedrooms. Example: 1
     * @queryParam beds_max integer Maximum number of bedrooms. Example: 3
     * @queryParam sort_by string Sort by field. Options: updated_at, launch_date, price_per_sqft. Default: updated_at. Example: price_per_sqft
     * @queryParam sort_direction string Sort direction. Options: asc, desc. Default: desc. Example: asc
     * @queryParam per_page integer Number of projects per page. Default: 20. Max: 50. Example: 50
     * @queryParam page int The page number for pagination. For example: 2
     * @queryParam search string Comprehensive search across project name, description, developer name, city, district, and neighbourhood. Example: Tridel downtown toronto
     *
     * @response 200 scenario="Successful response" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Central Park Residences",
     *       "description": "A premium residential complex in downtown.",
     *       "media": "['url']",
     *       "completion_year": 2025,
     *       "status": "pre-sale",
     *       "city_id": 3,
     *       "city_name": "Toronto",
     *       "deposit_with_time": null,
     *       "deposit_full": null,
     *       "deposit": null,
     *       "size": null,
     *       "launch_price": null,
     *       "district_id": 5,
     *       "district_name": "Downtown",
     *       "neighbourhood_id": 17,
     *       "neighbourhood_name": "Financial District",
     *       "architect_id": 4,
     *       "interior_designer_id": 2,
     *       "developer_id": 7,
     *       "developer_name": "Tridel Corporation",
     *       "storeys": 25,
     *       "suites": null,
     *       "units": 120,
     *       "development_status": "in progress",
     *       "building_type": "Condominium",
     *       "building_height_m": 75,
     *       "underground_levels": null,
     *       "launch_date": "2024-08-01",
     *       "occupancy_date": "2026-05-01",
     *       "address": "123 Main St, Downtown",
     *       "google_map_link": null,
     *       "walk_score": 87,
     *       "transit_score": 90,
     *       "location": null,
     *       "current_price_from": 650000,
     *       "current_price_to": 1200000,
     *       "total_parking": null,
     *       "residential_parking": null,
     *       "parking_ratio": null,
     *       "residential_parking_ratio": null,
     *       "visitor_parking": null,
     *       "industrial_parking": null,
     *       "office_parking": null,
     *       "retail_parking": null,
     *       "bike_parking": null,
     *       "parking_price": null,
     *       "parking_details": null,
     *       "locker_price": null,
     *       "locker_details": null,
     *       "current_sales_status": null,
     *       "current_psf_avg": 1100,
     *       "launch_psf_avg": null,
     *       "maintenance_fees": null,
     *       "maintenance_fees_details": null,
     *       "floorplan_premiums": null,
     *       "development_charges": null,
     *       "google_drive_portal": null,
     *       "amenities": "Pool,Gym,Concierge,Parking",
     *       "gfa": null,
     *       "price_per_sqft": null,
     *       "bedrooms_info": null,
     *       "bedrooms": "1-bedroom: 45 units, 2-bedroom: 60 units, 3-bedroom: 15 units",
     *       "bedrooms_percents": "1-bedroom: 37.5%, 2-bedroom: 50%, 3-bedroom: 12.5%",
     *       "highlights": "Premium location, Modern amenities, Panoramic city views",
     *       "launch_price_project": 480000,
     *       "created_at": "2024-05-01T08:13:17.000000Z",
     *       "updated_at": "2024-05-15T08:13:17.000000Z"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://your-app.test/api/v1/projects?page=1",
     *     "last": "http://your-app.test/api/v1/projects?page=5",
     *     "prev": null,
     *     "next": "http://your-app.test/api/v1/projects?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 5,
     *     "path": "http://your-app.test/api/v1/projects",
     *     "per_page": 20,
     *     "to": 20,
     *     "total": 100
     *   }
     * }
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [
            Search::class, // Add comprehensive search first
            Name::class,
            SalesStatus::class,
            Cities::class,
            Districts::class,
            Neighbourhoods::class,
            ConstructionStatus::class,
            Type::class,
            OccupancyDate::class,
            LaunchDate::class,
            LaunchPsfAvg::class,
            LaunchPrice::class,
            PricePerSqft::class,
            CurrentPriceRange::class,
            InteriorSize::class,
            MaintenanceFees::class,
            ParkingPrice::class,
            LockerPrice::class,
            DeveloperName::class,
            ArchitectNameOrSlug::class,
            SalesMarketingCompany::class,
            Storeys::class,
            BuildingHeight::class,
            Suites::class,
            Beds::class,
            Deposit::class,
            Sort::class,
        ];

        $perPage = request('per_page', 20);
        // Ensure per_page is within reasonable bounds
        $perPage = max(1, min(50, (int) $perPage));

        $projects = app(Pipeline::class)
            ->send(Project::with('salesMarketingCompanies', 'specialIncentives', 'latestDocuments',
                'historicalDocuments', 'city', 'district', 'neighbourhood', 'developer'))
            ->through($filters)
            ->thenReturn()
            ->paginate($perPage);

        return response($this->paginatedResponse($projects, ProjectResource::class), 200);
    }

    /**
     * Get a single project
     *
     * Retrieve detailed information about a specific project by its unique ID.
     *
     * @group Endpoints
     * @subgroup Projects
     *
     * @urlParam id integer required The ID of the project. Example: 1
     *
     * @response 200 scenario="Successful response" {
     *   "data": {
     *     "id": 1,
     *     "name": "Central Park Residences",
     *     "description": "A premium residential complex in downtown.",
     *     "media": [
     *         url,
     *          ..
     *     ]",
     *     "completion_year": 2025,
     *     "status": "pre-sale",
     *     "city_id": 3,
     *     "city_name": "Toronto",
     *     "deposit_with_time": null,
     *     "deposit_full": null,
     *     "deposit": null,
     *     "size": null,
     *     "launch_price": null,
     *     "district_id": 5,
     *     "district_name": "Downtown",
     *     "neighbourhood_id": 17,
     *     "neighbourhood_name": "Financial District",
     *     "architect_id": 4,
     *     "interior_designer_id": 2,
     *     "developer_id": 7,
     *     "developer_name": "Tridel Corporation",
     *     "storeys": 25,
     *     "suites": null,
     *     "units": 120,
     *     "development_status": "in progress",
     *     "building_type": "Condominium",
     *     "building_height_m": 75,
     *     "underground_levels": null,
     *     "launch_date": "2024-08-01",
     *     "occupancy_date": "2026-05-01",
     *     "address": "123 Main St, Downtown",
     *     "google_map_link": null,
     *     "walk_score": 87,
     *     "transit_score": 90,
     *     "location": null,
     *     "current_price_from": 650000,
     *     "current_price_to": 1200000,
     *     "total_parking": null,
     *     "residential_parking": null,
     *     "parking_ratio": null,
     *     "residential_parking_ratio": null,
     *     "visitor_parking": null,
     *     "industrial_parking": null,
     *     "office_parking": null,
     *     "retail_parking": null,
     *     "bike_parking": null,
     *     "parking_price": null,
     *     "parking_details": null,
     *     "locker_price": null,
     *     "locker_details": null,
     *     "current_sales_status": null,
     *     "current_psf_avg": 1100,
     *     "launch_psf_avg": null,
     *     "maintenance_fees": null,
     *     "maintenance_fees_details": null,
     *     "floorplan_premiums": null,
     *     "development_charges": null,
     *     "google_drive_portal": null,
     *     "amenities": "Pool,Gym,Concierge,Parking",
     *     "gfa": null,
     *     "price_per_sqft": null,
     *     "bedrooms_info": null,
     *     "bedrooms": "1-bedroom: 45 units, 2-bedroom: 60 units, 3-bedroom: 15 units",
     *     "bedrooms_percents": "1-bedroom: 37.5%, 2-bedroom: 50%, 3-bedroom: 12.5%",
     *     "highlights": "Premium location, Modern amenities, Panoramic city views",
     *     "launch_price_project": 480000,
     *     "created_at": "2024-05-01T08:13:17.000000Z",
     *     "updated_at": "2024-05-15T08:13:17.000000Z"
     *   }
     * }
     *
     * @param  int  $id
     * @return ProjectResource
     */
    public function show($id)
    {
        $project = Project::with('salesMarketingCompanies', 'specialIncentives', 'latestDocuments',
            'historicalDocuments', 'city', 'district', 'neighbourhood', 'developer')->findOrFail($id);
        return new ProjectResource($project);
    }
}
