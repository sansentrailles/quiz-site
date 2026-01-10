<?php

namespace app\custom\widgets\frontend\pager;

use yii\widgets\LinkPager;
use yii\helpers\Html;

class CustomPager extends LinkPager
{
    public $options = ['class' => 'pagination'];
    public $linkOptions = ['class' => 'pagination-link'];
    public $activePageCssClass = 'active';
    public $disabledPageCssClass = 'disabled';
    
    public $prevPageLabel = '<i class="fas fa-chevron-left"></i>';
    public $nextPageLabel = '<i class="fas fa-chevron-right"></i>';
    
    public $disableCurrentPageButton = true;
    
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkOptions;
        $options['aria-label'] = 'Страница ' . $page;
        
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
            $options['aria-label'] = 'Текущая страница ' . $page;
        }
        
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            return Html::tag('a', $label, $options);
        }
        
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        
        return Html::a($label, $this->pagination->createUrl($page), $options);
    }
    
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        
        $buttons = [];
        $currentPage = $this->pagination->getPage();
        
        // Кнопка "предыдущая"
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton(
                $this->prevPageLabel,
                $page,
                $this->prevPageCssClass,
                $currentPage <= 0,
                false
            );
        }
        
        // Кнопки страниц с многоточием
        $internalPages = $this->getInternalPages($currentPage, $pageCount);
        foreach ($internalPages as $page) {
            if ($page === '...') {
                $buttons[] = Html::tag('span', '...');
            } else {
                $buttons[] = $this->renderPageButton(
                    $page + 1,
                    $page,
                    null,
                    false,
                    $page == $currentPage
                );
            }
        }
        
        // Кнопка "следующая"
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton(
                $this->nextPageLabel,
                $page,
                $this->nextPageCssClass,
                $currentPage >= $pageCount - 1,
                false
            );
        }
        
        return Html::tag('div', implode("\n", $buttons), $this->options);
    }
    
    private function getInternalPages($currentPage, $pageCount)
    {
        $pages = [];
        
        if ($pageCount <= 7) {
            // Если страниц мало, показываем все
            for ($i = 0; $i < $pageCount; $i++) {
                $pages[] = $i;
            }
        } else {
            // Показываем первую, последнюю и текущую с соседями
            $pages[] = 0;
            
            if ($currentPage > 3) {
                $pages[] = '...';
            }
            
            $start = max(1, $currentPage - 1);
            $end = min($pageCount - 2, $currentPage + 1);
            
            for ($i = $start; $i <= $end; $i++) {
                $pages[] = $i;
            }
            
            if ($currentPage < $pageCount - 4) {
                $pages[] = '...';
            }
            
            $pages[] = $pageCount - 1;
        }
        
        return $pages;
    }
}
