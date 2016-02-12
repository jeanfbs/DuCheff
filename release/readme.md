Observações

Existe um arquivo .htaccess no diretorio app que bloqueia todo acesso a pasta via
HTTP GET. O arquivo esta oculto.

A ultima mudança que voce fez foi de modificar todas as rotas de Ajax do sistema
precisa fazer os teste para validar se estão funcionando.

Modificar todo os ajax para suportar a Loading Gif


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
