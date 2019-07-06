<?php
    function findDistance($coords1,$coords2){
        $deltaX=$coords1->x-$coords2->x;
        $deltaY=$coords1->y-$coords2->y;
        return sqrt(pow($deltaX,2)+pow($deltaY,2));
    }

    function edgesIntersection($a1,$a2,$b1,$b2){//пересекаются ли ребра
        $v1=($b2->x-$b1->x)*($a1->y-$b1->y)-($b2->y-$b1->y)*($a1->x-$b1->x);
        $v2=($b2->x-$b1->x)*($a2->y-$b1->y)-($b2->y-$b1->y)*($a2->x-$b1->x);
        $v3=($a2->x-$a1->x)*($b1->y-$a1->y)-($a2->y-$a1->y)*($b1->x-$a1->x);
        $v4=($a2->x-$a1->x)*($b2->y-$a1->y)-($a2->y-$a1->y)*($b2->x-$a1->x);
        return (($v1*$v2<0) && ($v3*$v4<0));
    }

    function formDistanceMatrix($coordsArr){
        $distanceMatrix=array();
        for($i=0;$i<count($coordsArr);$i++){
            $distanceMatrix[$i]=array();
            for($j=0;$j<count($coordsArr);$j++){
                $distanceMatrix[$i][$j]=findDistance($coordsArr[$i],$coordsArr[$j]);
            }
        }
        return $distanceMatrix;
    }

    function createAdjacencyMatrix($coordsArr){
        $adjacencyMatrix=array();
        for($i=0;$i<count($coordsArr);$i++){
            $adjacencyMatrix[$i]=array();
            for($j=0;$j<count($coordsArr);$j++){
                $adjacencyMatrix[$i][$j]=0;
            }
        }
        return $adjacencyMatrix;
    }

    function findMinEl(&$distanceMatrix){
        $min=array(value=>$distanceMatrix[0][1],row=>0,col=>1);
        foreach ($distanceMatrix as $keyRow => $valueArr) {
            foreach ($distanceMatrix[$keyRow] as $keyColumn => $value) {
                if($value<$min[value]&&$value!=0){
                    $min[value]=$value;
                    $min[row]=$keyRow;
                    $min[col]=$keyColumn;
                }
            }
        }
        $distanceMatrix[$min[row]][$min[col]]=10000;
        return $min;
    }

    function isGraphConnected($adjactencyMatrix){
        for($i=0;$i<count($adjactencyMatrix);++$i){
            for($j=0;$j<count($adjactencyMatrix[$i]);++$j){
                if($i==$j)continue;
                if(!isTwoVertexesContact($adjactencyMatrix,$i,$j))return false;
            }
        }
        return true;
    }
    function isTwoVertexesContact($matrix,$vertex1,$vertex2){
        $vertEmpty=true;
        for($i=0;$i<count($matrix[$vertex1]);$i++){
            if($matrix[$vertex1][$i]==1)$vertEmpty=false;
        }
        if($vertEmpty)return false;

        $connectedToVertex1=false;
        $connectedToVertex2=false;
        foreach ($matrix as $key => $value) {
            for($i=0;$i<count($value);$i++){
                if($value[$i]==1){
                    if($key==$vertex2)$connectedToVertex2=true;
                    unset($matrix[$key]);
                    unset($matrix[$i]);
                    if(isTwoVertexesContact($matrix,$key,$vertex2)){
                        $connectedToVertex2=true;
                    }
                }
            }
        }
        return $connectedToVertex1&&$connectedToVertex2;
    }

    function isPlanar($adjacencyMatrix,$min,$coordsArr){
        foreach ($adjacencyMatrix as $keyRow => $valueRow) {
            foreach ($valueRow as $keyCol => $valueCol) {
                if($valueCol==1){
                    $vert1=$coordsArr[$keyRow];
                    $vert2=$coordsArr[$keyCol];
                    $vert3=$coordsArr[$min[row]];
                    $vert4=$coordsArr[$min[col]];
                    if(edgesIntersection($vert1,$vert2,$vert3,$vert4))return false;
                }
            }
        }
        return true;
    }   
?>