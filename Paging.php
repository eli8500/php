<?php
class Paging {



    public static function pagingRange($Page,$TotalPagesPerPage, $MaxPages=null,$TotalRecord=null, $PageSize=null )
    {
        /**
         * @autor Eli Meiler
         * @date 2014-10-02
         *
         * requered
         * $Page -number of selected page
         * $TotalPagesPerPage - range of pages to display
         *
         * optional(one of option is requered!!!)
         *
         * 1)$MaxPages - maximum pages that can be
         * 2)$TotalRecord - number of ads totaly
         *   $PageSize - number of adds in one page
         *
         * RETURN
         *
         * array("StartPage"=>$low_range,"EndPage"=>$high_range,'MaxPages'=>$MaxPages)
         * OR
         * false
         *
         */

        if((int)$TotalRecord>0 && (int)$PageSize>0){
            $MaxPages = ($TotalRecord-($TotalRecord%$PageSize))/$PageSize;
            if($TotalRecord%$PageSize>0){
                $MaxPages++;
            }
        }

        if(!((int)$MaxPages>0)){
            return false;
        }



        //find range for current page
        $low_range = $Page-$Page%$TotalPagesPerPage+1;

        if($Page%$TotalPagesPerPage==0){
            $low_range-=$TotalPagesPerPage;
        }

        $high_range = (($low_range+$TotalPagesPerPage-1)<$MaxPages)?$low_range+$TotalPagesPerPage-1:$MaxPages;

        $middle = ceil($low_range+($TotalPagesPerPage-1)/2);

        if($Page<$middle){
            if($Page>1){
                $dec = $middle-$Page;
                while($dec--){
                    if($low_range-1>0){
                        $low_range--;
                        $high_range--;
                    }else{
                        break;
                    }
                }
            }
            //else stay like it
        }else if($Page>$middle){
            $inc = $high_range-$middle;
            if($Page%$TotalPagesPerPage!=0){
                $inc--;
            }
            while($inc--){
                if($high_range+1<=$MaxPages){
                    $low_range++;
                    $high_range++;
                }else{
                    break;
                }
            }
        }


        return array("StartPage"=>$low_range,"EndPage"=>$high_range,'MaxPages'=>$MaxPages);
    }
}

Paging:: pagingRange(10,5,200);
Paging:: pagingRange(10,5,null,200,5);