import Data.List

unique_vertices graph = nub ([ a | (a,b,c)<-graph] ++ [ b | (a,b,c)<-graph])

-- Taking input from a file
main = do
    text <- readFile "data_in.txt"
    let transactions = map words (lines text)--print (lines text)
        unique_vertices = sort (nub ( (map (\list-> list !! 0) transactions) ++ (map (\list-> list !! 1) transactions) ))
        u = (map (\list-> list !! 0) transactions) -- giver
        v = (map (\list-> list !! 1) transactions) -- taker
        w = (map (\list-> list !! 2) transactions) -- amount
        
        giver = [(vertex,read weight :: Int) | (vertex,weight) <- zip u w]
        taker = [(vertex,(- read weight :: Int)) | (vertex,weight) <- zip v w]  -- negate the taker
        
        netPayers = sort (giver ++ taker)
        bipartite_vertices = [ (v,w) |  v<-unique_vertices, w <-[sum (map snd (filter (\s-> v == (fst s)) netPayers))]]
        left_temp = filter (\s->snd s >0) bipartite_vertices
        right_temp' = filter (\s->snd s < 0) bipartite_vertices
        right_temp = [(a,-b) | (a,b)<-right_temp'] --making amount to be paid as positive which was made negative earlier
        
        exact l1 l2 = [(a1,a2,b1) | (a1,b1)<-l1,(a2,b2)<-l2,b1==b2]
        common_left l1 l2 = [(a1,b1) | (a1,b1)<-l1,(a2,b2)<-l2,b1==b2]
        common_right l1 l2 = [(a2,b2) | (a1,b1)<-l1,(a2,b2)<-l2,b1==b2]
        
        -- Left set of vertices without any common element between left and right set of vertices
        left = filter (\(a,b)-> (a,b) `notElem` (common_left left_temp  right_temp )) left_temp 
        -- Right set of vertices without any common element between left and right set of vertices
        right = filter (\(a,b)-> (a,b) `notElem` (common_right left_temp  right_temp )) right_temp 
        
        result = (exact left_temp right_temp) ++ (merge_t left right)


    --print giver
    --print taker
    --print netPayers
    --print bipartite_vertices
    --print left
    --print right
        
    writeFile "data_out.txt" $ unlines [ "\""++a++"\""++" "++"\""++b++"\""++" "++(show c) | (a,b,c)<-result ]
    --print (5)
        
    --return unique_vertices
    
merge_t l [] = []
merge_t [] l = []
merge_t (x:xs) (y:ys) | (snd x) < (snd y) = (fst x,fst y,snd x) : merge_t xs ((fst y, (snd y) - (snd x)):ys)
                      | (snd x) > (snd y) = (fst x,fst y,snd y): merge_t ((fst x ,(snd x)-(snd y)):xs) ys
                      | otherwise = (fst x, fst y, snd x):merge_t xs ys -- snd x = snd y
                    

    
   
{-



toPay_temp graph = [(u,w) | (u,v,w)<-graph]
present_Vertices_Pay graph = nub [u | (u,w)<-toPay_temp graph]
toPay graph vertices = (toPay_temp graph) ++ [(u,0) | u<-vertices, u `notElem` (present_Vertices_Pay graph)] 
pay graph vertices = sort [(fst x,sum (map snd (x:xs))) | (x:xs)<- [ (filter (\(a,b)->a==v) (toPay graph vertices)) | v<-vertices]]


toGet_temp graph = [ (v,w) | (u,v,w)<-graph]
present_Vertices_Get graph = nub [u | (u,w)<-toGet_temp graph]
toGet graph vertices = (toGet_temp graph) ++ [(u,0) | u<-vertices, u `notElem` (present_Vertices_Get graph)] 
get graph vertices = sort [(fst x,sum (map snd (x:xs))) | (x:xs)<- [ (filter (\(a,b)->a==v) (toGet graph vertices)) | v<-vertices]]

netPay graph vertices = [(fst a, (snd a)-(snd b)) | (a,b)<-zip (pay graph vertices) (get graph vertices) ]

-- Forming bipartite graph
left_temp graph vertices = sort [(b,a)|(a,b)<-filter (\(u,w)->w>0) (netPay graph vertices)]
right_temp graph vertices = sort [((-b),a)|(a,b)<-filter (\(u,w)->w<0) (netPay graph vertices)]

-- First remove if there are any exact demand and supply then apply remove

exact l1 l2 = [(b1,b2,a1) | (a1,b1)<-l1,(a2,b2)<-l2,a1==a2]
common_left l1 l2 = [(a1,b1) | (a1,b1)<-l1,(a2,b2)<-l2,a1==a2]
common_right l1 l2 = [(a2,b2) | (a1,b1)<-l1,(a2,b2)<-l2,a1==a2]

left graph vertices = filter (\(a,b)-> (a,b) `notElem` (common_left (left_temp graph vertices) (right_temp graph vertices))) (left_temp graph vertices) 

right graph vertices = filter (\(a,b)-> (a,b) `notElem` (common_right (left_temp graph vertices) (right_temp graph vertices))) (right_temp graph vertices) 


merge l [] = []
merge [] l = []
merge (x:xs) (y:ys) | (fst x) < (fst y) = (snd x,snd y,fst x) : merge xs (((fst y) - (fst x), snd y):ys)
                    | (fst x) > (fst y) = (snd x,snd y,fst y): merge (((fst x)-(fst y),snd x):xs) ys
                    | otherwise = (snd x, snd y, fst x):merge xs ys -- fst x = fst y
                    
                    
                    
result graph vertices =  (exact (left_temp graph vertices) (right_temp graph vertices)) ++ (merge (left graph vertices) (right graph vertices))      
                    
arr_result graph = writeFile "data_out.txt" $ unlines [ "\""++a++"\""++" "++"\""++b++"\""++" "++(show c) | (a,b,c)<-result graph (unique_vertices graph)]
                    
                    
                    -}
                    
                    
