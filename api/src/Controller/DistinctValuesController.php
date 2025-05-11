<?php

namespace App\Controller;

use App\Repository\SmartphoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DistinctValuesController extends AbstractController
{
    public function __construct(private SmartphoneRepository $smartphoneRepository)
    {
    }

    #[Route('/api/smartphone/categories', name: 'get_categories', methods: ['GET'])]
    public function getCategories(): JsonResponse
    {
        $categories = $this->smartphoneRepository->findDistinctValues('category');

        return $this->json($categories);
    }

    #[Route('/api/smartphone/brands', name: 'get_brands', methods: ['GET'])]
    public function getBrands(): JsonResponse
    {
        $brands = $this->smartphoneRepository->findDistinctValues('brand');

        return $this->json($brands);
    }

    #[Route('/api/smartphone/models', name: 'get_models', methods: ['GET'])]
    public function getModels(): JsonResponse
    {
        $models = $this->smartphoneRepository->findDistinctValues('model');

        return $this->json($models);
    }

    #[Route('/api/smartphone/grades', name: 'get_grades', methods: ['GET'])]
    public function getGrades(): JsonResponse
    {
        $grades = $this->smartphoneRepository->findDistinctValues('grade');

        return $this->json($grades);
    }

    #[Route('/api/smartphone/conditions', name: 'get_conditions', methods: ['GET'])]
    public function getConditions(): JsonResponse
    {
        $conditions = $this->smartphoneRepository->findDistinctValues('condition');

        return $this->json($conditions);
    }

    #[Route('/api/smartphone/price-range', name: 'get_price_range', methods: ['GET'])]
    public function getPriceRange(): JsonResponse
    {
        $priceRange = $this->smartphoneRepository->findPriceRange();

        return $this->json($priceRange);
    }
}
