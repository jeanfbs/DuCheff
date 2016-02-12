DELETE FROM `itens_pedido_bebida`;
DELETE FROM `item_pedido_variedade`;
DELETE FROM `item_pedido_adicional`;
DELETE FROM `item_pedido`;
DELETE FROM `pedidos`;


ALTER TABLE itens_pedido_bebida AUTO_INCREMENT=0;
ALTER TABLE item_pedido_variedade AUTO_INCREMENT=0;
ALTER TABLE item_pedido_adicional AUTO_INCREMENT=0;
ALTER TABLE item_pedido AUTO_INCREMENT=0;
ALTER TABLE pedidos AUTO_INCREMENT=0;