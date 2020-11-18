<?php

namespace AHT\Portfolio\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use AHT\Portfolio\Api\Data\AuthorInterface;

/**
 * @api
 */
interface AuthorRepositoryInterface
{
    /**
     * Save page.
     *
     * @param AuthorInterface $author
     * @return AuthorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(AuthorInterface $author);

    /**
     * Retrieve Author.
     *
     * @param int $authorId
     * @return AuthorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($authorId);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \AHT\Portfolio\Api\Data\AuthorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete author.
     *
     * @param AuthorInterface $author
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(AuthorInterface $author);

    /**
     * Delete author by ID.
     *
     * @param int $authorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($authorId);
}