<?php
/**
 * Pagination Feature.
 *
 * @package    Silla
 * @subpackage Core\Modules\DB\Features\Paginator
 * @author     Kalin Stefanov <kalin@athlonsofia.com>
 * @copyright  none
 * @licence    GPL http://www.gnu.org/copyleft/gpl.html
 */

namespace Core\Modules\DB\Features\Paginator;

/**
 * Paginator Page class.
 */
class Page extends Paginator
{
    /**
     * Current page number container.
     *
     * @var integer
     */
    public $pageNumber;

    /**
     * Paginator instance.
     *
     * @var Paginator
     */
    private $paginator;

    /**
     * Init method.
     *
     * @param Paginator $paginator  Paginator instance.
     * @param mixed     $pageNumber Number of page.
     */
    public function __construct(Paginator $paginator, $pageNumber)
    {
        $this->pageNumber = $pageNumber;
        $this->paginator = $paginator;
    }

    /**
     * Stingify method.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->pageNumber;
    }

    /**
     * First page getter.
     *
     * @return boolean|Page
     */
    public function first()
    {
        return $this->pageNumber === 1;
    }

    /**
     * Last page getter.
     *
     * @return boolean|Page
     */
    public function last()
    {
        return $this->pageNumber === $this->paginator->pagesCount;
    }

    /**
     * Curreng page getter.
     *
     * @return boolean|Page
     */
    public function current()
    {
        return $this->pageNumber === $this->paginator->currentPage;
    }
}
