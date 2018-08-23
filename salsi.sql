-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2018 a las 06:49:29
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `salsi`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ADD_C` (IN `pid_locacion` INT)  BEGIN
	DECLARE IDL INT;
	DECLARE EL INT;
	DECLARE IDT INT;
	DECLARE CUENTA INT;

	SET IDL=0;
	SET EL=0;
	SET IDT=0;
	SET CUENTA=0;
	
			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
			if IDL > 0 THEN
				select estado into EL from locaciones where id_locacion=pid_locacion;
				if EL = 2 then

					select locaciones.id_ticket into IDT from locaciones where id_locacion=pid_locacion;
					select MAX(descripcion) into CUENTA from cuentas where id_locacion=pid_locacion and estado=1;
					if CUENTA=null then
						select 'El proceso de pago de la locacion ha empezado' as mensaje;
					else
						SET CUENTA=CUENTA+1;
						insert into cuentas values(null,CUENTA,pid_locacion,IDT,1,0,0,0,0,now());	
						select 'Cuenta añadida' as mensaje;
					end if;

				else
				select 'La locacion no se encuentra ocupada' as mensaje;
				end if;
			else
			select 'La locacion no existe' as mensaje;
			end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_B` (IN `pcant` FLOAT, IN `pid_bebida` INT, IN `pid_locacion` INT, IN `pid_ingrediente_s` INT, IN `pcantidad_s` FLOAT, IN `pid_ingrediente_ss` INT, IN `pcantidad_ss` FLOAT, IN `pid_usuario` INT, IN `pid_cuenta` INT)  BEGIN
	
	DECLARE IDB INT;		
	DECLARE IDL INT;
	DECLARE IDI INT;  
	DECLARE ES INT;  
	DECLARE EL INT;        
	DECLARE EB INT;
	DECLARE EI INT;
	DECLARE RES INT;
	DECLARE ESI INT;
	DECLARE INS INT;
	DECLARE IDT INT;
	DECLARE IDVB INT;
	DECLARE CAN2 INT;
	DECLARE ET INT;
	DECLARE TB INT;
	DECLARE IDE INT;
	DECLARE IDC INT;

	DECLARE P FLOAT;        
	DECLARE SUB FLOAT;  
	DECLARE SUBN FLOAT;
	DECLARE CANB FLOAT;  
	DECLARE CANT FLOAT;
	DECLARE CANS FLOAT;
	DECLARE CANSS FLOAT;
	DECLARE CANTS FLOAT;  
	DECLARE CANTSS FLOAT;  
	DECLARE TOTI FLOAT;
	
		

	SET IDB=0;			
	SET IDL=0;
	SET IDI=0;
	SET ES=0;       
	SET EL=0;        
	SET EB=0; 
	SET EI=0;       
	SET RES=0;
	SET ESI=0;
	SET INS=0;
	SET IDT=0;
	SET IDVB=0;
	SET CAN2=0;
	SET ET=0;
	SET TB=0;
	SET IDE=0;

	SET SUB=0;
	SET SUBN=0;
	SET P=0;        
	SET CANB=0;
	SET CANT=0;
	SET CANS=0;
	SET CANSS=0;
	SET CANTS=0;
	SET CANTSS=0;
	SET TOTI=0;
	SET IDC=0;

	select id_cuenta into IDC from cuentas where id_cuenta=pid_cuenta;
	if IDC>0 then
		select max(id_sesion) into INS from t_sesiones;								
		select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI=1 THEN

			select estado into EL from locaciones where id_locacion=pid_locacion;
				if EL = 2 THEN

				select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
					if IDL> 0 then

						select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
						if IDT > 0 then

							select estado into ET from tickets where id_ticket=IDT;
							if ET=1 then

								select id_bebida into IDB from bebidas where id_bebida=pid_bebida;
									if IDB >0 then

									select estado into EB from bebidas where id_bebida=IDB;
										if EB=1 THEN
											
											select id_ingrediente into IDI from ingredientes where id_ingrediente=pid_ingrediente_s;
											if IDI > 0 then

												select estado into EI from ingredientes where id_ingrediente=IDI;
												if EI=1 then

													select id_ventaB into IDVB from ventasB,locaciones,tickets,cuentas where ventasB.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_locacion=locaciones.id_locacion and cuentas.id_ticket=tickets.id_ticket and ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_bebida=IDB and ventasB.id_cuenta=pid_cuenta;
													if IDVB > 0 then
														select id_tipo_de_a into TB from bebidas where id_bebida=IDB;
															if TB=1 then
																select cantidad into CAN2 from ventasB where id_ventaB=IDVB;
																SET CAN2=CAN2+pcant;
															    select precio into P from bebidas where id_bebida=pid_bebida;
															    SET SUB=CAN2*P;	
															    SET SUBN=pcant*P;
															    update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
															   	update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta; 	
															    update ventasB set cantidad=CAN2,subtotal=SUB where id_ventaB=IDVB;	
															    select 'La venta ha sido exitosa' as mensaje;	
															else
															
																if TB=2 then
																	select id_ingrediente into IDI from bebidas where id_bebida=IDB; 
																	if IDI>0 then
																		if pid_ingrediente_s=pid_ingrediente_ss then

																			select cantidad_p into CANB from bebidas where id_bebida=IDB;
																			select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																			select cantidad into CANS from ingredientes where id_ingrediente=pid_ingrediente_s;

																			SET CANTS=pcant*pcantidad_s;
																			SET CANTSS=pcant*pcantidad_ss;
																			SET CANTS=CANTS+CANTSS;
																			SET CANT=pcant*CANB;
																			SET CANT=TOTI-CANT;
																			SET CANTS=CANS-CANTS;
																			
																			if CANT>=0 then
																				if CANTS>=0 then
																					
																						update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																						update ingredientes set cantidad=CANTS where id_ingrediente=pid_ingrediente_s;
																						select cantidad into CAN2 from ventasB where id_ventaB=IDVB;
																						SET CAN2=CAN2+pcant;
																						select precio into P from bebidas where id_bebida=IDB;
																						SET SUB=CAN2*P;	
																						SET SUBN=pcant*P;
																						update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
																						update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta;	
																						update ventasB set cantidad=CAN2,subtotal=SUB where id_ventaB=IDVB;
																						select 'La venta ha sido exitosa' as mensaje;
															
																				else
																					select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																				end if;	
																			else
																				select 'La existencia es insuficiente para realizar la venta' as mensaje;
																			end if;
																		else
																			select cantidad_p into CANB from bebidas where id_bebida=IDB;
																			select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																			select cantidad into CANS from ingredientes where id_ingrediente=pid_ingrediente_s;
																			select cantidad into CANSS from ingredientes where id_ingrediente=pid_ingrediente_ss;
																			SET CANTS=pcant*pcantidad_s;
																			SET CANTSS=pcant*pcantidad_ss;
																			SET CANT=pcant*CANB;
																			SET CANT=TOTI-CANT;
																			SET CANTS=CANS-CANTS;
																			SET CANTSS=CANSS-CANTSS;
																			if CANT>=0 then
																				if CANTS>=0 then
																					if CANTSS>=0 then
																						update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																						update ingredientes set cantidad=CANTS where id_ingrediente=pid_ingrediente_s;
																						update ingredientes set cantidad=CANTSS where id_ingrediente=pid_ingrediente_ss;	
																						select cantidad into CAN2 from ventasB where id_ventaB=IDVB;
																						SET CAN2=CAN2+pcant;
																						select precio into P from bebidas where id_bebida=IDB;
																						SET SUB=CAN2*P;	
																						SET SUBN=pcant*P;
																						update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
																						update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta;	
																						update ventasB set cantidad=CAN2,subtotal=SUB where id_ventaB=IDVB;
																						select 'La venta ha sido exitosa' as mensaje;
																					else
																						select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																					end if;
																				else
																					select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																				end if;	
																			else
																				select 'La existencia es insuficiente para realizar la venta' as mensaje;
																			end if;
																		end if;
																	else
																		select 'El ingrediente no existe' as mensaje;
																	end if;
																else
																select 'Error en tipo de alimento' as mensaje;
																end if;
															end if;
													else
														select id_tipo_de_a into TB from bebidas where id_bebida=IDB;
															if TB=1 then
																select precio into P from bebidas where id_bebida=pid_bebida;
																SET SUB=P*pcant;	
																update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
																update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;				                            
																insert into ventasB values(null,pcant,pid_bebida,SUB,pid_cuenta,1,pid_usuario,3,pid_ingrediente_s,pcantidad_s,pid_ingrediente_ss,pcantidad_ss);
																select 'La venta ha sido exitosa' as mensaje;
															else
							
																if TB=2 then
																	select id_ingrediente into IDI from bebidas where id_bebida=IDB; 
																	if IDI>0 then
																		if pid_ingrediente_s=pid_ingrediente_ss then
																			select cantidad_p into CANB from bebidas where id_bebida=IDB;
																			select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																			select cantidad into CANS from ingredientes where id_ingrediente=pid_ingrediente_s;
				
																			SET CANTS=pcant*pcantidad_s;
																			SET CANTSS=pcant*pcantidad_ss;
																			SET CANTS=CANTS+CANTSS;
																			SET CANT=pcant*CANB;
																			SET CANT=TOTI-CANT;
																			SET CANTS=CANS-CANTS;
																	
																			if CANT>=0 then
																				if CANTS>=0 then
												
																						update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																						update ingredientes set cantidad=CANTS where id_ingrediente=pid_ingrediente_s;
																						select precio into P from bebidas where id_bebida=IDB;
																						SET SUB=P*pcant;	
																						update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
																						update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;				                            
																						insert into ventasB values(null,pcant,pid_bebida,SUB,pid_cuenta,1,pid_usuario,3,pid_ingrediente_s,pcantidad_s,pid_ingrediente_ss,pcantidad_ss);
																						select 'La venta ha sido exitosa' as mensaje;
																	
																				else
																					select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																				end if;	
																			else
																				select 'La existencia es insuficiente para realizar la venta' as mensaje;
																			end if;
																		else
																			select cantidad_p into CANB from bebidas where id_bebida=IDB;
																			select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																			select cantidad into CANS from ingredientes where id_ingrediente=pid_ingrediente_s;
																			select cantidad into CANSS from ingredientes where id_ingrediente=pid_ingrediente_ss;
																			SET CANTS=pcant*pcantidad_s;
																			SET CANTSS=pcant*pcantidad_ss;
																			SET CANT=pcant*CANB;
																			SET CANT=TOTI-CANT;
																			SET CANTS=CANS-CANTS;
																			SET CANTSS=CANSS-CANTSS;
																			if CANT>=0 then
																				if CANTS>=0 then
																					if CANTSS>=0 then
																						update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																						update ingredientes set cantidad=CANTS where id_ingrediente=pid_ingrediente_s;
																						update ingredientes set cantidad=CANTSS where id_ingrediente=pid_ingrediente_ss;	
																						select precio into P from bebidas where id_bebida=IDB;
																						SET SUB=P*pcant;	
																						update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
																						update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;				                            
																						insert into ventasB values(null,pcant,pid_bebida,SUB,pid_cuenta,1,pid_usuario,3,pid_ingrediente_s,pcantidad_s,pid_ingrediente_ss,pcantidad_ss);
																						select 'La venta ha sido exitosa' as mensaje;
																					else
																						select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																					end if;
																				else
																					select 'La existencia del ingrediente secundario es insuficiente para realizar la venta' as mensaje;
																				end if;	
																			else
																				select 'La existencia es insuficiente para realizar la venta' as mensaje;
																			end if;
																		end if;

																	else
																		select 'El ingrediente no existe' as mensaje;
																	end if;
																else
																select 'Error en tipo de alimento' as mensaje;
																end if;
															end if;
													end if;

												else
												select 'El ingrediente no se encuentra activo' as mensaje;
												end if;

											else
											select 'El ingrediente no existe' as mensaje;
											end if;

										else                       
										select 'El alimento está dado de baja' as mensaje;                         
										end if;	

									else		
									select 'El alimento no existe en el catálogo' as mensaje;		
									end if;

								else
								select 'El ticket no existe' as mensaje;
								end if;

							else
							select 'El ticket no se encuentra activo para ventas' as mensaje;
							end if;	

					else	
					select 'La locacion no existe' as mensaje;	
					end if; 

				else                   
				select 'El estado de la locacion no es ocupado' as mensaje;                  
				end if;	

			else
			select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
			end if;	 
	else
	select 'La cuenta tiene un error' as mensaje;
	end if;
	
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_C` (IN `pid_locacion` INT, IN `pdescripcion` VARCHAR(40), IN `pprecio` FLOAT, IN `pcantidad` INT, IN `pid_usuario` INT, IN `pid_cuenta` INT)  BEGIN
		
	
	DECLARE IDL INT;
	DECLARE IDC INT;
	DECLARE IDCC INT;
	DECLARE IDT INT;	
	DECLARE EL INT;
	DECLARE ESI INT;
	DECLARE INS INT;
	DECLARE CAN2 INT;

	DECLARE SUB FLOAT;
	DECLARE SUBN FLOAT;
	DECLARE P FLOAT;

	

	SET IDL=0;	
	SET IDC=0;
	SET IDCC=0;
	SET IDT=0;
	SET EL=0;
	SET ESI=0;
	SET INS=0;
	SET CAN2=0;

	SET SUB=0;
	SET SUBN=0;
	SET P=0;

		select id_cuenta into IDCC from cuentas where id_cuenta=pid_cuenta;
		if IDCC > 0 then
			select max(id_sesion) into INS from t_sesiones;								
		select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI=1 THEN	

			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
				if IDL > 0 then  

				select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
				if IDT > 0 then

					select estado into EL from locaciones where id_locacion=IDL;           
					if EL = 2 THEN	

							select id_complemento into IDC from complementos,locaciones,tickets,cuentas where complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket and cuentas.id_locacion=locaciones.id_locacion and cuentas.estado=1 and complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and complementos.descripcion=pdescripcion and complementos.id_cuenta=pid_cuenta;
							if IDC > 0 then
								select cantidad into CAN2 from complementos where id_complemento=IDC;
								SET CAN2=CAN2+pcantidad;
								select precio into P from complementos where id_complemento=IDC;
								SET SUB=CAN2*P;
								SET SUBN=pcantidad*P;
								update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
								update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta;	
								update complementos set cantidad=CAN2,subtotal=SUB where id_complemento=IDC;
								select 'La venta ha sido exitosa' as mensaje;	
							else
								SET SUB=pprecio*pcantidad;
								update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
								update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;	
								insert into complementos values (null,pid_cuenta,pdescripcion,pprecio,pcantidad,SUB,1,pid_usuario,2);
								select 'La venta ha sido exitosa' as mensaje;
							end if;			

					else            
					select 'El estado de la locacion no es ocupado' as mensaje;            
					end if;	

				else
				select 'El ticket no existe' as mensaje;
				end if;		

			else        
			select 'La locacion no existe' as mensaje;		
			end if;	

		else
		select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
		end if;			
		else
		select 'Hay un error con la cuenta' as mensaje;
		end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_V` (IN `pcant` INT, IN `pid_alimento` INT, IN `pid_locacion` INT, IN `pid_usuario` INT, IN `pid_cuenta` INT)  BEGIN
	
	DECLARE IDA INT;		
	DECLARE IDL INT;  
	DECLARE ES INT;  
	DECLARE EL INT;        
	DECLARE EA INT;
	DECLARE RES INT;
	DECLARE ESI INT;
	DECLARE INS INT;
	DECLARE IDT INT;
	DECLARE IDV INT;
	DECLARE CAN2 INT;
	DECLARE ET INT;
	DECLARE TA INT;
	DECLARE IDI INT;
	DECLARE IDE INT;
	DECLARE IDC INT;

	DECLARE P FLOAT;        
	DECLARE SUB FLOAT;  
	DECLARE SUBN FLOAT;
	DECLARE CANA FLOAT;  
	DECLARE CANT FLOAT;    
	DECLARE TOTI FLOAT;
	
		

	SET IDA=0;			
	SET IDL=0;
	SET ES=0;       
	SET EL=0;        
	SET EA=0;        
	SET RES=0;
	SET ESI=0;
	SET INS=0;
	SET IDT=0;
	SET IDV=0;
	SET CAN2=0;
	SET ET=0;
	SET TA=0;
	SET IDI=0;
	SET IDE=0;
	SET IDC=0;

	SET SUB=0;
	SET SUBN=0;
	SET P=0;        
	SET CANA=0;
	SET CANT=0;
	SET TOTI=0;

	select id_cuenta into IDC from cuentas where id_cuenta=pid_cuenta;

	if IDC > 0 then
		select max(id_sesion) into INS from t_sesiones;								
		select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI=1 THEN

			select estado into EL from locaciones where id_locacion=pid_locacion;
				if EL = 2 THEN

				select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
					if IDL> 0 then

						select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
						if IDT > 0 then

							select estado into ET from tickets where id_ticket=IDT;
							if ET=1 then

								select id_alimento into IDA from alimentos where id_alimento=pid_alimento;
									if IDA >0 then

									select estado into EA from alimentos where pid_alimento=id_alimento;
										if EA=1 THEN
											select id_venta into IDV from ventas,locaciones,tickets,cuentas where ventas.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_locacion=locaciones.id_locacion and cuentas.id_ticket=tickets.id_ticket and ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_alimento=IDA and ventas.id_cuenta=pid_cuenta;
												if IDV > 0 then
													select id_tipo_de_a into TA from alimentos where id_alimento=IDA;
														if TA=1 then
															select cantidad into CAN2 from ventas where id_venta=IDV;
															SET CAN2=CAN2+pcant;
														    select precio into P from alimentos where id_alimento=pid_alimento;
														    SET SUB=CAN2*P;	
														    SET SUBN=pcant*P;
														    update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
														   	update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta; 	
														    update ventas set cantidad=CAN2,subtotal=SUB where id_venta=IDV;	
														    select 'La venta ha sido exitosa' as mensaje;	
														else
														
															if TA=2 then
																select id_ingrediente into IDI from alimentos where id_alimento=IDA; 
																if IDI>0 then
																	select cantidad_p into CANA from alimentos where id_alimento=IDA;
																	select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																	SET CANT=pcant*CANA;
																	SET CANT=TOTI-CANT;
																	if CANT>=0 then
																		update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																		select cantidad into CAN2 from ventas where id_venta=IDV;
																		SET CAN2=CAN2+pcant;
																		select precio into P from alimentos where id_alimento=pid_alimento;
																		SET SUB=CAN2*P;	
																		SET SUBN=pcant*P;
																		update tickets set subtotal=subtotal+SUBN where id_ticket=IDT;
																		update cuentas set subtotal=subtotal+SUBN where id_cuenta=pid_cuenta;	
																		update ventas set cantidad=CAN2,subtotal=SUB where id_venta=IDV;
																		select 'La venta ha sido exitosa' as mensaje;	
																	else
																		select 'La existencia es insuficiente para realizar la venta' as mensaje;
																	end if;
																else
																	select 'El ingrediente no existe' as mensaje;
																end if;
															else
															select 'Error en tipo de alimento' as mensaje;
															end if;
														end if;
												else
													select id_tipo_de_a into TA from alimentos where id_alimento=IDA;
														if TA=1 then
															select precio into P from alimentos where id_alimento=pid_alimento;
															SET SUB=P*pcant;	
															update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
															update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;				                            
															insert into ventas values(null,pcant,pid_alimento,SUB,pid_cuenta,1,pid_usuario,1);
															select 'La venta ha sido exitosa' as mensaje;
														else
														
															if TA=2 then
																select id_ingrediente into IDI from alimentos where id_alimento=IDA; 
																if IDI>0 then
																	select cantidad_p into CANA from alimentos where id_alimento=IDA;
																	select cantidad into TOTI from ingredientes where id_ingrediente=IDI;
																	SET CANT=pcant*CANA;
																	SET CANT=TOTI-CANT;
																	if CANT>=0 then
																		update ingredientes set cantidad=CANT where id_ingrediente=IDI;
																		select precio into P from alimentos where id_alimento=pid_alimento;
																		SET SUB=P*pcant;	
																		update tickets set subtotal=subtotal+SUB where id_ticket=IDT;
																		update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;				                            
																		insert into ventas values(null,pcant,pid_alimento,SUB,pid_cuenta,1,pid_usuario,1);
																		select 'La venta ha sido exitosa' as mensaje;	
																	else
																		select 'La existencia es insuficiente para realizar la venta' as mensaje;
																	end if;

																else
																	select 'El ingrediente no existe' as mensaje;
																end if;
															else
															select 'Error en tipo de alimento' as mensaje;
															end if;
														end if;
												end if;

										else                       
										select 'El alimento está dado de baja' as mensaje;                         
										end if;	

									else		
									select 'El alimento no existe en el catálogo' as mensaje;		
									end if;

								else
								select 'El ticket no existe' as mensaje;
								end if;

							else
							select 'El ticket no se encuentra activo para ventas' as mensaje;
							end if;	

					else	
					select 'La locacion no existe' as mensaje;	
					end if; 

				else                   
				select 'El estado de la locacion no es ocupado' as mensaje;                  
				end if;	

			else
			select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
			end if;	
	else
	select 'Hay un error en la cuenta' as mensaje;
	end if;	
		 
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CAN_B` (IN `pid_ventaB` INT, IN `pid_bebida` INT, IN `pid_cuenta` INT, IN `pcantidad` INT)  BEGIN
	
	DECLARE IDVB INT;
	DECLARE IDB INT;
	DECLARE IDL INT;
	DECLARE IDT INT;
	DECLARE CAN INT;
	DECLARE CANCT INT;
	DECLARE ET INT;
	DECLARE ITA INT;
	DECLARE IDI INT;
	DECLARE IDIS INT;
	DECLARE IDISS INT;

	DECLARE PREA FLOAT;
	DECLARE SUBN FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;
	DECLARE C FLOAT;
	DECLARE CS FLOAT;
	DECLARE CSS FLOAT;

	SET IDVB=0;
	SET IDB=0;
	SET IDL=0;
	SET IDT=0;
	SET CAN=0;
	SET CANCT=0;
	SET ET=0;
	SET ITA=0;
	SET IDI=0;
	SET IDIS=0;
	SET IDISS=0;


	SET PREA=0;
	SET SUBN=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;
	SET C=0;
	SET CS=0;
	SET CSS=0;

				select id_ventaB into IDVB from ventasB where id_ventaB=pid_ventaB;
				if IDVB > 0 then

					select ventasB.id_bebida into IDB from ventasB,bebidas where ventasB.id_bebida=bebidas.id_bebida and ventasB.id_bebida=pid_bebida group by id_bebida;
					if IDB > 0 then

						select id_locacion into IDL from cuentas where id_cuenta=pid_cuenta;
						if IDL > 0 then

							select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
							if IDT > 0 then

								select estado into ET from tickets where id_ticket=IDT;
								if ET=1 then

									select cantidad into CAN from ventasB where id_ventaB=IDVB;
									if pcantidad > CAN then
										select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
									else
										select id_tipo_de_a into ITA from bebidas where id_bebida=pid_bebida;
										if ITA=2 then
											if CAN = pcantidad then
												select id_ingrediente into IDI from bebidas where id_bebida=IDB;
												select id_ingrediente_s into IDIS from ventasB where id_ventaB=IDVB;
												select id_ingrediente_ss into IDISS from ventasB where id_ventaB=IDVB;
												select subtotal into SUBCT from ventasB where id_ventaB=IDVB;
												select cantidad into CANCT from ventasB where id_ventaB=IDVB;
												select cantidad_p into C from bebidas where id_bebida=IDB;
												select cantidad_s into CS from ventasB where id_ventaB=IDVB;
												select cantidad_ss into CSS from ventasB where id_ventaB=IDVB;

												set C=C*CANCT;
												set CS=CS*CANCT;
												SET CSS=CSS*CANCT;
												update ingredientes set cantidad=cantidad+C where id_ingrediente=IDI;
												update ingredientes set cantidad=cantidad+CS where id_ingrediente=IDIS;
												update ingredientes set cantidad=cantidad+CSS where id_ingrediente=IDISS;	
												update ventasB set cantidad=cantidad-CANCT,subtotal=subtotal-SUBCT,estado=2 where id_ventaB=IDVB;
													
												update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
												update cuentas set subtotal=subtotal-SUBCT where id_cuenta=pid_cuenta;	
												select 'La venta a sido cancelada' as mensaje;
												select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
												if SUBCOMPRO = 0 then
													update tickets set estado=3 where id_ticket=IDT;
													update cuentas set estado=3 where id_ticket=IDT;	
													update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
													select 'Locacion liberada' as mensaje;
												end if;
											else
												select id_ingrediente into IDI from bebidas where id_bebida=IDB;
												select id_ingrediente_s into IDIS from ventasB where id_ventaB=IDVB;
												select id_ingrediente_ss into IDISS from ventasB where id_ventaB=IDVB;
												select cantidad_p into C from bebidas where id_bebida=IDB;
												select cantidad_s into CS from ventasB where id_ventaB=IDVB;
												select cantidad_ss into CSS from ventasB where id_ventaB=IDVB;
												select precio into PREA from bebidas where id_bebida=IDB;
												SET SUBN=pcantidad*PREA;
												SET C=C*pcantidad;
												SET CS=CS*pcantidad;
												SET CSS=CSS*pcantidad;

												update ingredientes set cantidad=cantidad+C where id_ingrediente=IDI;
												update ingredientes set cantidad=cantidad+CS where id_ingrediente=IDIS;
												update ingredientes set cantidad=cantidad+CSS where id_ingrediente=IDISS;	
												
												update ventasB set subtotal=subtotal-SUBN,cantidad=cantidad-pcantidad where id_ventaB=IDVB;
												update cuentas set subtotal=subtotal-SUBN where id_cuenta=pid_cuenta;	
												update tickets set subtotal=subtotal-SUBN where id_ticket=IDT;	
												select 'Productos cancelados' as mensaje;
											end if;
										else
											if ITA=1 then
												if CAN = pcantidad then
													select subtotal into SUBCT from ventasB where id_ventaB=IDVB;
													select cantidad into CANCT from ventasB where id_ventaB=IDVB;

													update ventasB set cantidad=cantidad-CANCT,subtotal=subtotal-SUBCT,estado=2 where id_ventaB=IDVB;
														
													update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
													update cuentas set subtotal=subtotal-SUBCT where id_cuenta=pid_cuenta;		
													select 'La venta a sido cancelada' as mensaje;
													select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
													if SUBCOMPRO = 0 then
														update tickets set estado=3 where id_ticket=IDT;
														update cuentas set estado=3 where id_ticket=IDT;		
														update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
														select 'Locacion liberada' as mensaje;	
													end if;
												else
													select precio into PREA from bebidas where id_bebida=IDB;
													SET SUBN=pcantidad*PREA;

													update ventasB set cantidad=cantidad-pcantidad,subtotal=subtotal-SUBN where id_ventaB=IDVB;
													
													update cuentas set subtotal=subtotal-SUBN where id_cuenta=pid_cuenta;	
													update tickets set subtotal=subtotal-SUBN where id_ticket=IDT;	
													select 'Productos cancelados' as mensaje;
												end if;
											else
											select 'Error de cancelacion' as mensaje;
											end if;
										end if;
									end if;

								else
								select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
								end if;	

							else
							select 'No cuenta con algun ticket activo o se encuentra en estado de adedudo' as mensaje;
							end if;

						else
						select 'La locacion no existe' as mensaje;
						end if;

					else
					select 'El alimento no existe' as mensaje;
					end if;

				else
				select 'La venta no existe' as mensaje;
				end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CAN_C` (IN `pid_complemento` INT, IN `pid_cuenta` INT, IN `pcantidad` INT, IN `pid_usuario` INT)  BEGIN
	
	DECLARE IDC INT;	
	DECLARE IDL INT;	
	DECLARE IC INT;	
	DECLARE IDT INT;
	DECLARE EL INT;   
	DECLARE ET INT; 
	DECLARE CAN INT;
	DECLARE ESC INT;

	DECLARE SUB FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;
	DECLARE PREC FLOAT;
	
	SET IDC=0;
	SET IDL=0;
	SET IC=0;	
	SET IDT=0;
	SET EL=0;   
	SET ET=0;
	SET CAN=0;
	SET ESC=0;

	SET SUB=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;
	SET PREC=0;

		
		select id_complemento into IDC from complementos where id_complemento=pid_complemento;
		if IDC > 0 then

			select id_locacion into IDL from cuentas where id_cuenta=pid_cuenta;		
			if IDL > 0 then 

				select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
				if IDT > 0 then

					select estado into ET from tickets where id_ticket=IDT;
					if ET=1 then

						select estado into EL from locaciones where id_locacion=IDL;                   
						if EL = 2 THEN   			            				
						
							select estado into ESC from cuentas where id_cuenta=pid_cuenta;
							if ESC=2 then
							select 'La cuenta ya se encuentra en proceso de pago' as mensaje;
							else
								if ESC=1 then
									select cantidad into CAN from complementos where id_complemento=IDC;
									if 	pcantidad > CAN then
										select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
									else
										if CAN= pcantidad then
											select subtotal into SUBCT from complementos where id_complemento=IDC;

											update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
											update cuentas set subtotal=subtotal-SUBCT where id_cuenta=pid_cuenta;	
											update complementos set estado=2 where id_complemento=IDC;
											select 'La venta ha sido cancelada' as mensaje;
											
											select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
												if SUBCOMPRO = 0 then
													update tickets set estado=3 where id_ticket=IDT;
													update cuentas set estado=3 where id_ticket=IDT;	
													update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
													select 'La locacion ha sido liberada' as mensaje;	
											end if;	
										else
											select precio into PREC from complementos where id_complemento=IDC;
											SET SUB=pcantidad*PREC;

											update complementos set subtotal=subtotal-SUB,cantidad=cantidad-pcantidad where id_complemento=IDC;
											update cuentas set subtotal=subtotal-SUB where id_cuenta=pid_cuenta;	
											update tickets set subtotal=subtotal-SUB where id_ticket=IDT;	
											select 'Productos cancelados' as mensaje;
										end if;
									end if;
								else
									select 'Error de cuenta' as mensaje;
								end if;
							end if;			
						else                   
						select 'El estado de la locacion no es activo' as mensaje;                   
						end if;

					else
					select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
					end if;	

				else
				select 'El ticket no existe' as mensaje;
				end if;	

			else        
			select 'El la locacion no existe' as mensaje;		
			end if;	

		else
		select 'El complemento no existe' as mensaje;
		end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CAN_V` (IN `pid_venta` INT, IN `pid_alimento` INT, IN `pid_cuenta` INT, IN `pcantidad` INT)  BEGIN
	
	DECLARE IDV INT;
	DECLARE IDA INT;
	DECLARE IDL INT;
	DECLARE IDT INT;
	DECLARE CAN INT;
	DECLARE CANCT INT;
	DECLARE ET INT;
	DECLARE ITA INT;
	DECLARE IDI INT;

	DECLARE PREA FLOAT;
	DECLARE SUBN FLOAT;
	DECLARE SUBCT FLOAT;
	DECLARE SUBCOMPRO FLOAT;
	DECLARE C FLOAT;

	SET IDV=0;
	SET IDA=0;
	SET IDL=0;
	SET IDT=0;
	SET CAN=0;
	SET CANCT=0;
	SET ET=0;
	SET ITA=0;
	SET IDI=0;


	SET PREA=0;
	SET SUBN=0;
	SET SUBCT=0;
	SET SUBCOMPRO=0;
	SET C=0;

				select id_venta into IDV from ventas where id_venta=pid_venta;
				if IDV > 0 then

					select ventas.id_alimento into IDA from ventas,alimentos where ventas.id_alimento=alimentos.id_alimento  and ventas.id_alimento=pid_alimento group by id_alimento;
					if IDA > 0 then

						select id_locacion into IDL from cuentas where id_cuenta=pid_cuenta;
						if IDL > 0 then

							select locaciones.id_ticket into IDT from locaciones,tickets where locaciones.id_ticket=tickets.id_ticket and tickets.estado=1 and locaciones.estado=2 and id_locacion=IDL;
							if IDT > 0 then

								select estado into ET from tickets where id_ticket=IDT;
								if ET=1 then

									select cantidad into CAN from ventas where id_venta=IDV;
									if pcantidad > CAN then
										select 'No se puede cancelar mas de la cantidad vendida' as mensaje;
									else
										select id_tipo_de_a into ITA from alimentos where id_alimento=pid_alimento;
										if ITA=2 then
											if CAN = pcantidad then
												select id_ingrediente into IDI from alimentos where id_alimento=IDA;
												select subtotal into SUBCT from ventas where id_venta=IDV;
												select cantidad into CANCT from ventas where id_venta=IDV;
												select cantidad_p into C from alimentos where id_alimento=IDA;

												set C=C*CANCT;
												update ingredientes set cantidad=cantidad+C where id_ingrediente=IDI;
												update ventas set cantidad=cantidad-CANCT,subtotal=subtotal-SUBCT,estado=2 where id_venta=IDV;
													
												update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
												update cuentas set subtotal=subtotal-SUBCT where id_cuenta=pid_cuenta;	
												select 'La venta a sido cancelada' as mensaje;
												select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
												if SUBCOMPRO = 0 then
													update tickets set estado=3 where id_ticket=IDT;
													update cuentas set estado=3 where id_ticket=IDT;	
													update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
													select 'Locacion liberada' as mensaje;
												end if;
											else
												select id_ingrediente into IDI from alimentos where id_alimento=IDA;
												select cantidad_p into C from alimentos where id_alimento=IDA;
												select precio into PREA from alimentos where id_alimento=IDA;
												SET SUBN=pcantidad*PREA;
												SET C=C*pcantidad;

												update ingredientes set cantidad=cantidad+C where id_ingrediente=IDI;
												
												update ventas set subtotal=subtotal-SUBN,cantidad=cantidad-pcantidad where id_venta=IDV;
												update cuentas set subtotal=subtotal-SUBN where id_cuenta=pid_cuenta;	
												update tickets set subtotal=subtotal-SUBN where id_ticket=IDT;	
												select 'Productos cancelados' as mensaje;
											end if;
										else
											if ITA=1 then
												if CAN = pcantidad then
													select subtotal into SUBCT from ventas where id_venta=IDV;
													select cantidad into CANCT from ventas where id_venta=IDV;

													update ventas set cantidad=cantidad-CANCT,subtotal=subtotal-SUBCT,estado=2 where id_venta=IDV;
														
													update tickets set subtotal=subtotal-SUBCT where id_ticket=IDT;
													update cuentas set subtotal=subtotal-SUBCT where id_cuenta=pid_cuenta;		
													select 'La venta a sido cancelada' as mensaje;
													select	subtotal into SUBCOMPRO from tickets where id_ticket=IDT;
													if SUBCOMPRO = 0 then
														update tickets set estado=3 where id_ticket=IDT;
														update cuentas set estado=3 where id_ticket=IDT;		
														update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
														select 'Locacion liberada' as mensaje;	
													end if;
												else
													select precio into PREA from alimentos where id_alimento=IDA;
													SET SUBN=pcantidad*PREA;

													update ventas set cantidad=cantidad-pcantidad,subtotal=subtotal-SUBN where id_venta=IDV;
													
													update cuentas set subtotal=subtotal-SUBN where id_cuenta=pid_cuenta;	
													update tickets set subtotal=subtotal-SUBN where id_ticket=IDT;	
													select 'Productos cancelados' as mensaje;
												end if;
											else
											select 'Error de cancelacion' as mensaje;
											end if;
										end if;
									end if;

								else
								select 'El ticket  se encuentra adeudado no se puede realizar algun otro cambio' as mensaje;
								end if;	

							else
							select 'No cuenta con algun ticket activo o se encuentra en estado de adedudo' as mensaje;
							end if;

						else
						select 'La locacion no existe' as mensaje;
						end if;

					else
					select 'El alimento no existe' as mensaje;
					end if;

				else
				select 'La venta no existe' as mensaje;
				end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CIERRE_S` (IN `pid_usuario` INT, IN `pcantidad_i` FLOAT)  BEGIN
	
	DECLARE CS INT;
	DECLARE EC INT;
	DECLARE EI INT;
	DECLARE IDR INT;
	DECLARE TOT FLOAT;
	DECLARE TOTE FLOAT;
	DECLARE TOTC FLOAT;
	DECLARE TOTCL FLOAT;
	DECLARE TOTF FLOAT;
	DECLARE IDT INT;
	DECLARE IDC INT;
	DECLARE FI DATETIME;
	
	SET CS=0;
	SET EC=0;
	SET EI=0;
	SET IDR=0;
	SET TOT=0;
	SET TOTE=0;
	SET TOTC=0;
	SET TOTCL=0;
	SET TOTF=0;
	SET IDT=0;
	SET IDC=0;
	
			select id_role into IDR from usuarios where id_usuario=pid_usuario;
			if IDR=2 then

				select count(id_sesion) into CS from t_sesiones;
				if CS > 0 then 

					select count(id_ticket) into IDT from tickets where estado=1;
					if IDT > 0 then
						select 'Quedan tickets activos' as mensaje;
					else
						select count(id_cuenta) into IDC from cuentas where estado=2;
						if IDC > 0 then
							select 'Quedan cuentas adeudadas' as mensaje;
						else
							select estado_i into EI from t_sesiones where id_sesion=CS;
							select estado_c into EC from t_sesiones where id_sesion=CS;

							if EC=2 && EI=1 then 
								update t_sesiones set estado_i=2,fecha_c=now(),estado_c=1,id_usuario_c=pid_usuario where id_sesion=CS;
								select fecha_i into FI from t_sesiones where id_sesion=CS;	
								select IF(ISNULL(sum(total)),0,sum(total)) into	TOT from tickets where estado=0 and fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS);
								select IF(ISNULL(sum(cuentas.total_e)),0,sum(cuentas.total_e))into TOTE from metodos_p,cuentas where cuentas.fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS) AND cuentas.estado=0 and metodos_p.id_mp=1 and cuentas.id_cuenta=metodos_p.id_cuenta; 
								select IF(ISNULL(sum(cuentas.total_c)),0,sum(cuentas.total_c)) into TOTC from cuentas,metodos_p where cuentas.fecha between (select fecha_i from t_sesiones where id_sesion=CS) and (select fecha_c from t_sesiones where id_sesion=CS) AND cuentas.estado=0 and metodos_p.id_mp=2 and cuentas.id_cuenta=metodos_p.id_cuenta; 
								SET TOTF=TOT;
								SET TOT=TOT+pcantidad_i;
								insert into bitacoraCor values (null,TOT,TOTE,TOTC,pcantidad_i,TOTF,FI,now(),pid_usuario);	
								select 'Corte de dia hecho' as mensaje;
							end if;
						end if;
					end if;

				else
				select 'La sesion no existe' as mensaje;
				end if;	

			else
			select 'No tiene los privilegios para cerrar un corte de caja' as mensaje;
			end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CLEAR_L` (IN `pid_locacion` INT)  BEGIN
	DECLARE IDL INT;
	DECLARE EL INT;
	DECLARE IDT INT;
	DECLARE CUENTA INT;
	DECLARE SUB FLOAT;
	DECLARE CC INT;

	SET IDL=0;
	SET EL=0;
	SET IDT=0;
	SET CUENTA=0;
	SET SUB=0;
	SET CC=0;
	
			select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
			if IDL > 0 THEN
				select estado into EL from locaciones where id_locacion=pid_locacion;
				if EL = 2 then

					select id_ticket into IDT from locaciones where id_locacion=pid_locacion;
					if IDT > 0 THEN

						select subtotal into SUB from tickets where id_ticket=IDT and estado=1;
						if SUB=0 then 
							select count(id_cuenta) into CC from cuentas,tickets where tickets.total>0 and tickets.id_ticket=IDT and cuentas.id_ticket=tickets.id_ticket;
							if CC > 0 then
								update tickets set estado=0 where id_ticket=IDT;
								update cuentas set estado=3 where id_locacion=IDL and total=0 and total_e=0 and total_c=0 and estado=1;	
								update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
								select 'La locacion a sido liberada' as mensaje;
							else
								update tickets set estado=3 where id_ticket=IDT;
								update cuentas set estado=3 where id_locacion=IDL;	
								update locaciones set estado=1,id_ticket=0 where id_locacion=IDL;
								select 'La locacion a sido liberada' as mensaje;
							end if;	
						else
						select 'La locacion se encuentra adeudada' as mensaje;
						end if;
					else
					select 'El ticket no existe' as mensaje;
					end if;
					
				else
				select 'La locacion no se encuentra ocupada' as mensaje;
				end if;
			else
			select 'La locacion no existe' as mensaje;
			end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ENTRADAS` (IN `pid_ingrediente` INT, IN `pcantidad` FLOAT, IN `fecha_cc` DATETIME, IN `pid_proveedor` INT)  BEGIN
	
	DECLARE IDI INT;
	DECLARE IDP INT;
	DECLARE ESTI INT;

	SET IDI=0;
	SET IDP=0;
	SET ESTI=0;

	select id_ingrediente into IDI from ingredientes where pid_ingrediente=id_ingrediente;
	if IDI > 0 then

		select id_proveedor into IDP from proveedores where pid_proveedor=id_proveedor;
		if IDP > 0 then

			select estado into ESTI from ingredientes where id_ingrediente=IDI;
			if ESTI = 1 then
				insert into entradas values (null,IDI,pcantidad,Curdate(),fecha_cc,IDP,1);
				update ingredientes set cantidad=cantidad+pcantidad,fecha_c=fecha_cc where id_ingrediente=IDI;
				select 'Se han agregado las existencias correcta mente' as mensaje;	
			else
				insert into entradas values (null,IDI,pcantidad,Curdate(),fecha_cc,IDP,1);
				update ingredientes set cantidad=pcantidad,fecha_c=fecha_cc where id_ingrediente=IDI;
				select 'Se han agregado las existencias correcta mente' as mensaje;	
			end if;
		else
			select 'El proveedor no existe' as mensaje;
		end if;
	else
		select 'El ingrediente no existe' as mensaje;
	end if;
			
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `INICIAR_S` (IN `pid_usuario` INT)  BEGIN
	
	DECLARE CS INT;
	DECLARE EC INT;
	DECLARE EI INT;
	DECLARE IDR INT;

	SET CS=0;
	SET EC=0;
	SET EI=0;
	SET IDR=0;

				select id_role into IDR from usuarios where id_usuario=pid_usuario;
				if IDR=2 then

					select IF(ISNULL(max(id_sesion)),0,max(id_sesion)) into CS from t_sesiones;
					if CS > 0 then

						select estado_i into EI from t_sesiones where id_sesion=CS;
						select estado_c into EC from t_sesiones where id_sesion=CS;

						if EC=1 && EI=2 then
							insert into t_sesiones values(null,now(),1,null,2,pid_usuario,0);
						end if;

					else
					insert into t_sesiones values(null,now(),1,null,2,pid_usuario,0);
					end if;

				end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LENTRADAS` (IN `pid_entrada` INT)  BEGIN

	DECLARE IDE INT;	
	DECLARE ESTE INT;

	SET IDE=0;
	SET ESTE=0;

	select id_entrada into IDE from entradas where id_entrada=pid_entrada;
	if IDE > 0 then
		select estado into ESTE from entradas where id_entrada=IDE;
		if ESTE=1 then
			update entradas set estado=2 where id_entrada=IDE;
			select 'Baja exitosa' as mensaje;	
		else
			select 'La entrada ha rebasado su fecha de caducidad' as mensaje;
		end if;
	else
		select 'La entrada no existe' as mensaje;
	end if;		
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LENTRADASC` (IN `pid_entrada` INT, IN `pcantidad` FLOAT)  BEGIN

	DECLARE IDE INT;	
	DECLARE ESTE INT;
	DECLARE IDI INT;
	DECLARE CANI FLOAT;
	DECLARE CANE FLOAT;

	SET IDE=0;
	SET ESTE=0;
	SET IDI=0;
	SET CANI=0;
	SET CANE=0;

	select id_entrada into IDE from entradas where id_entrada=pid_entrada;
	if IDE > 0 then
		select estado into ESTE from entradas where id_entrada=IDE;
		if ESTE=3 then
			select id_ingrediente into IDI from entradas where id_entrada=IDE;
			if IDI > 0 then
				select cantidad into CANI from ingredientes where id_ingrediente=IDI;
				if CANi >= pcantidad then
					select cantidad_e into CANE from entradas where id_entrada=IDE;
					if CANE >= pcantidad then
						update entradas set estado=4 where id_entrada=IDE;
						update ingredientes set cantidad=cantidad-pcantidad where id_ingrediente=IDI;
						select 'Baja existosa' as mensaje;
					else
						select 'La cantidad a remover no puede ser mayor a la establecida en la entrada' as mensaje;
					end if;
				else 
					select 'La cantidad a remover no puede ser mayor a la establecida en el stock' as mensaje;
				end if;
			else
				select 'El ingrediente no existe' as mensaje;
			end if;
		else
			select 'Los ingredientes a un se encuentran en buen estado' as mensaje;
		end if;
	else
		select 'La entrada no existe' as mensaje;
	end if;		
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODIFICAR_C_C` (IN `pid_complemento` INT, IN `pid_cuenta` INT)  BEGIN
		
	DECLARE IDC INT;	
	DECLARE IDCU INT;
	DECLARE ES INT;
	DECLARE SUB FLOAT;
	DECLARE IDCUA INT;
	
	SET IDC=0;	
	SET IDCU=0;
	SET ES=0;
	SET SUB=0;
	SET IDCUA=0;
	
		select id_complemento into IDC from complementos where id_complemento=pid_complemento;
		if IDC > 0 THEN
			select id_cuenta into IDCU from cuentas where id_cuenta=pid_cuenta;
			IF IDCU > 0 THEN
				select estado into ES from cuentas where id_cuenta=IDCU;
				if ES = 1 THEN
					select subtotal into SUB from complementos where id_complemento=pid_complemento;
					select id_cuenta into IDCUA from complementos where id_complemento=pid_complemento;
					update cuentas set subtotal=subtotal-SUB where id_cuenta=IDCUA;

					update complementos set id_cuenta=pid_cuenta where id_complemento=pid_complemento;
					update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;	
					select 'Se ha efectuado el cambio' as mensaje;	
				else
				select 'La cuenta se encuntra cancelada o adeudada' as mensaje;
				end if;
			else
			select 'La cuenta no existe' as mensaje;
			END IF;
		else
		select 'La venta no existe' as mensaje;
		end IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODIFICAR_V` (IN `pid_venta` INT, IN `pid_cuenta` INT)  BEGIN
		
	DECLARE IDV INT;	
	DECLARE IDCU INT;
	DECLARE ES INT;
	DECLARE SUB FLOAT;
	DECLARE IDCUA INT;
	
	SET IDV=0;	
	SET IDCU=0;
	SET ES=0;
	SET SUB=0;
	SET IDCUA=0;
	
		select id_venta into IDV from ventas where id_venta=pid_venta;
		if IDV > 0 THEN
			select id_cuenta into IDCU from cuentas where id_cuenta=pid_cuenta;
			IF IDCU > 0 THEN
				select estado into ES from cuentas where id_cuenta=IDCU;
				if ES = 1 THEN
					select subtotal into SUB from ventas where id_venta=pid_venta;
					select id_cuenta into IDCUA from ventas where id_venta=pid_venta;
					update cuentas set subtotal=subtotal-SUB where id_cuenta=IDCUA;

					update ventas set id_cuenta=pid_cuenta where id_venta=pid_venta;
					update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;	
					select 'Se ha efectuado el cambio' as mensaje;	
				else
				select 'La cuenta se encuntra cancelada o adeudada' as mensaje;
				end if;
			else
			select 'La cuenta no existe' as mensaje;
			END IF;
		else
		select 'La venta no existe' as mensaje;
		end IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MODIFICAR_V_B` (IN `pid_venta` INT, IN `pid_cuenta` INT)  BEGIN

	DECLARE IDV INT;
	DECLARE IDCU INT;
	DECLARE ES INT;
	DECLARE SUB FLOAT;
	DECLARE IDCUA INT;

	SET IDV=0;
	SET IDCU=0;
	SET ES=0;
	SET SUB=0;
	SET IDCUA=0;

		select id_ventaB into IDV from ventasb where id_ventaB=pid_venta;
		if IDV > 0 THEN
			select id_cuenta into IDCU from cuentas where id_cuenta=pid_cuenta;
			IF IDCU > 0 THEN
				select estado into ES from cuentas where id_cuenta=IDCU;
				if ES = 1 THEN
					select subtotal into SUB from ventasb where id_ventaB=pid_venta;
					select id_cuenta into IDCUA from ventasb where id_ventaB=pid_venta;
					update cuentas set subtotal=subtotal-SUB where id_cuenta=IDCUA;

					update ventasb set id_cuenta=pid_cuenta where id_ventaB=pid_venta;
					update cuentas set subtotal=subtotal+SUB where id_cuenta=pid_cuenta;
					select 'Se ha efectuado el cambio' as mensaje;
				else
				select 'La cuenta se encuntra cancelada o adeudada' as mensaje;
				end if;
			else
			select 'La cuenta no existe' as mensaje;
			END IF;
		else
		select 'La venta no existe' as mensaje;
		end IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PAGO_C` (IN `pid_cuenta` INT, IN `pid_mp` INT, IN `pcantidad` FLOAT, IN `pid_empleado` INT, IN `pid_descuento` INT)  BEGIN
	DECLARE IDC INT;
	DECLARE IDMP INT;
	DECLARE IDEM INT;
	DECLARE IDT INT;
	DECLARE EST INT;
	DECLARE ESC INT;
	DECLARE IDL INT;
	DECLARE IDLD INT;
	DECLARE CONT INT;
	DECLARE CONT2 INT;
	DECLARE CONT3 INT;
	DECLARE CONT4 INT;

	DECLARE TOT FLOAT;
	DECLARE TOTV FLOAT;
	DECLARE TOTC FLOAT;
	DECLARE TOTB FLOAT;
	DECLARE TOTA FLOAT;
    DECLARE TOTD FLOAT;
    DECLARE SUBS FLOAT;
	DECLARE CAMBIO FLOAT;
	DECLARE DEUDA FLOAT;
	DECLARE POR FLOAT;
	DECLARE DEUDAA FLOAT;
	DECLARE RESIDUO FLOAT;
	DECLARE CANTIDAD FLOAT;

	SET IDC=0;
	SET IDMP=0;
	SET IDEM=0;
	SET IDT=0;
	SET EST=0;
	SET ESC=0;
	SET IDL=0;
	SET IDLD=0;
	SET CONT=0;
	SET CONT2=0;
	SET CONT3=0;
	SET CONT4=0;

	SET TOT=0;
	SET TOTV=0;
	SET TOTC=0;
	SET TOTB=0;
	SET TOTA=0;
    SET TOTD=0;
    SET SUBS=0;
	SET CAMBIO=0;
	SET DEUDA=0;
	SET POR=0;
	SET DEUDAA=0;
	SET RESIDUO=0;
	SET CANTIDAD=0;

		select id_cuenta into IDC from cuentas where id_cuenta=pid_cuenta;
		if IDC>0 then

			select id_ticket into IDT from cuentas where id_cuenta=IDC;
			if IDT > 0 then

				select id_mp into IDMP from metodos_de_p where id_mp=pid_mp;
					if IDMP > 0 then
						if IDMP = 1 then
							select id_empleado into IDEM from empleados where id_empleado=pid_empleado;
							if IDEM > 0 then

								select estado into ESC from cuentas where id_cuenta=pid_cuenta;
								if ESC = 1 then
									select count(id_cuenta) into CONT from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=2 and tickets.estado=1 and cuentas.id_ticket=IDT;
									if CONT > 0 then

										select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
										select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
										select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					

										SET TOT=TOTV+TOTC+TOTB;
										select monto into POR from descuentos where id_descuento=pid_descuento;
										SET POR=POR/100;
										SET POR=TOT*POR;
										SET POR=TOT-POR;
										SET CAMBIO=POR-pcantidad;

										update ventas set estado=0 where id_cuenta=IDC and estado=1;	
										update complementos set estado=0 where id_cuenta=IDC and estado=1;
										update ventasB set estado=0 where id_cuenta=IDC and estado=1;	

										if CAMBIO > 0 then
											update cuentas set total=total+pcantidad where id_cuenta=IDC;
											update tickets set total=total+pcantidad where id_ticket=IDT;
											update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
											update cuentas set estado=2 where id_cuenta=IDC;	
                                            update cuentas set subtotal=CAMBIO where id_cuenta=IDC;
											update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
											update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
											insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
											select 'Cuenta no pagada' as mensaje;

										else
											update tickets set total=total+POR where id_ticket=IDT;
											update cuentas set total=POR where id_cuenta=IDC;
											update cuentas set total_e=POR where id_cuenta=IDC;
                                            select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                            update tickets set subtotal=subtotal-SUBS where id_ticket=IDT;
											update cuentas set subtotal=0 where id_cuenta=IDC;
											update cuentas set estado=0 where id_cuenta=IDC;	
											update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
											insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
			                                
			                                    if CAMBIO=0 then
													select 'Cuenta Pagada' as mensaje;
			                                    else								
													select CONCAT('El cambio es:', ABS(CAMBIO));	
			                                    end if;
										end if;
									else 
										select count(id_cuenta) into CONT2 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=1 and tickets.estado=1 and cuentas.id_ticket=IDT;
										if CONT2 > 1 then 

											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
											select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;

											SET TOT=TOTV+TOTC+TOTB;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update ventas set estado=0 where id_cuenta=IDC and estado=1;	
											update complementos set estado=0 where id_cuenta=IDC and estado=1;
											update ventasB set estado=0 where id_cuenta=IDC and estado=1;	

											if CAMBIO > 0 then
												update cuentas set total=total+pcantidad where id_cuenta=IDC;
                                                update tickets set total=total+pcantidad where id_ticket=IDT;
												update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
												update cuentas set estado=2 where id_cuenta=IDC;	
												update cuentas set subtotal=CAMBIO where id_cuenta=IDC;
												update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
												update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
												select 'Cuenta no pagada' as mensaje;

											else
												update tickets set total=total+POR where id_ticket=IDT;
												update cuentas set total=POR where id_cuenta=IDC;
												update cuentas set total_e=POR where id_cuenta=IDC;
                                                select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                                update tickets set subtotal=subtotal-SUBS where id_ticket=IDT;
												update cuentas set subtotal=0 where id_cuenta=IDC;
												update cuentas set estado=0 where id_cuenta=IDC;	
												update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
				                                
				                                    if CAMBIO=0 then
														select 'Cuenta Pagada' as mensaje;
				                                    else								
														select CONCAT('El cambio es:', ABS(CAMBIO));	
				                                    end if;
											end if;
										else
											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
											select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;

											SET TOT=TOTV+TOTC+TOTB;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update ventas set estado=0 where id_cuenta=IDC and estado=1;	
											update complementos set estado=0 where id_cuenta=IDC and estado=1;
											update ventasB set estado=0 where id_cuenta=IDC and estado=1;	

												if CAMBIO > 0 then
													update cuentas set total=total+pcantidad where id_cuenta=IDC;
                                                    update tickets set total=total+pcantidad where id_ticket=IDT;
													update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
													update cuentas set estado=2 where id_cuenta=IDC;
													update cuentas set subtotal=CAMBIO where id_cuenta=IDC;
                                                    update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
													update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
													select 'Cuenta no pagada' as mensaje;

												else
													update tickets set total=total+POR where id_ticket=IDT;
                                                    update cuentas set total=POR where id_cuenta=IDC;
													update cuentas set total_e=POR where id_cuenta=IDC;
													select id_locacion into IDL from cuentas where id_cuenta=IDC;
													update locaciones set estado=1 where id_locacion=IDL;
													update locaciones set id_ticket=0 where id_locacion=IDL;	
													update tickets set subtotal=0 where id_ticket=IDT;
													update cuentas set subtotal=0 where id_cuenta=IDC;	
													update tickets set estado=0 where id_ticket=IDT;
													update cuentas set estado=0 where id_cuenta=IDC;	
													update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
			                                            if CAMBIO=0 then
															select 'Locacion Pagada' as mensaje;
			                                            else								
															select CONCAT('El cambio es:', ABS(CAMBIO));	
			                                            end if;
												end if;
										end if;	
									end if;
								else

									if ESC = 2 then
										select count(id_cuenta) into CONT3 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=1 and tickets.estado=1 and cuentas.id_ticket=IDT;
										if CONT3 > 0 then
												select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
												select monto into POR from descuentos where id_descuento=pid_descuento;
												

												SET POR=POR/100;
												SET POR=DEUDA*POR;												
												SET POR=DEUDA-POR;
												SET TOTD=POR-pcantidad;
												if TOTD > 0 then
													update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
													update cuentas set total=total+pcantidad where id_cuenta=IDC;
													update tickets set total=total+pcantidad where id_ticket=IDT;
                                                    select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                                    update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
													update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
													select 'Cuenta no pagada' as mensaje;
												else
													update cuentas set total_e=total_e+POR where id_cuenta=IDC;
													update cuentas set total=total+POR where id_cuenta=IDC;
													update tickets set total=total+POR where id_ticket=IDT;
													update tickets set subtotal=0 where id_ticket=IDT;
													update cuentas set subtotal=0 where id_cuenta=IDC;	
													update cuentas set estado=0 where id_cuenta=IDC;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                        	    if TOTD=0 then
															select 'Cuenta pagada' as mensaje;
						                                else    
															select CONCAT('El cambio es:', abs(TOTD));	
														end if;
												end if;
										else
											select count(id_cuenta) into CONT4 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=2 and tickets.estado=1 and cuentas.id_ticket=IDT;
											if CONT4 > 1 then
												select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
												select monto into POR from descuentos where id_descuento=pid_descuento;
												

												SET POR=POR/100;
												SET POR=DEUDA*POR;												
												SET POR=DEUDA-POR;
												SET TOTD=POR-pcantidad;
                                                
												if TOTD > 0 then
													update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
													update cuentas set total=total+pcantidad where id_cuenta=IDC;
													update tickets set total=total+pcantidad where id_ticket=IDT;
                                                    select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                                    update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
													update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
													select 'Cuenta no pagada' as mensaje;
												else
													update cuentas set total_e=total_e+POR where id_cuenta=IDC;
													update cuentas set total=total+POR where id_cuenta=IDC;
													update tickets set total=total+POR where id_ticket=IDT;
													update tickets set subtotal=0 where id_ticket=IDT;
													update cuentas set subtotal=0 where id_cuenta=IDC;	
													update cuentas set estado=0 where id_cuenta=IDC;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                        	    if TOTD=0 then
															select 'Cuenta pagada' as mensaje;
						                                else    
															select CONCAT('El cambio es:', abs(TOTD));	
														end if;
												end if;
											else
										
												select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
												select monto into POR from descuentos where id_descuento=pid_descuento;

												SET POR=POR/100;
												SET POR=DEUDA*POR;											
												SET POR=DEUDA-POR;
												SET TOTD=POR-pcantidad;
												

													if TOTD > 0 then
														update cuentas set total_e=total_e+pcantidad where id_cuenta=IDC;
														update cuentas set total=total+pcantidad where id_cuenta=IDC;
														update tickets set total=total+pcantidad where id_ticket=IDT;
                                                        select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                                        update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
														update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;
														insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
													    select 'Cuenta no pagada' as mensaje;
													else
														update cuentas set total_e=total_e+POR where id_cuenta=IDC;
														update cuentas set total=total+POR where id_cuenta=IDC;
														update tickets set total=total+POR where id_ticket=IDT;
														update tickets set subtotal=0 where id_ticket=IDT;
														update cuentas set subtotal=0 where id_cuenta=IDC;	
														update tickets set estado=0 where id_ticket=IDT;
														update cuentas set estado=0 where id_cuenta=IDC;
                                                        select id_locacion into IDLD from locaciones where id_ticket=IDT and estado=2;
														update locaciones set estado=1 where id_locacion=IDLD;
														update locaciones set id_ticket=0 where id_locacion=IDLD;
														insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                                   if DEUDA=0 then
																select 'Locacion pagada' as mensaje;
						                                    else    
																select CONCAT('El cambio es:', abs(TOTD));	
															end if;
													end if;
											end if;
										end if;
									else

										if ESC = 3 then
											select 'La cuenta ha sido cancelada' as mensaje;
										else

											if ESC = 0 then
												select 'La cuenta ha sido pagada' as mensaje;
											else
												select 'Error en la cuenta' as mensaje;
											end if;
										end if;
									end if;
								end if;
							else 
							select 'El empleado no existe' as mensaje;
							end if;	
						else
							select id_empleado into IDEM from empleados where id_empleado=pid_empleado;
							if IDEM > 0 then

								select estado into ESC from cuentas where id_cuenta=pid_cuenta;
								if ESC = 1 then
									select count(id_cuenta) into CONT from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=2 and tickets.estado=1 and cuentas.id_ticket=IDT;
									if CONT > 0 then

										select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
										select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
										select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;

										SET TOT=TOTV+TOTC+TOTB;
										select monto into POR from descuentos where id_descuento=pid_descuento;
										SET POR=POR/100;
										SET POR=TOT*POR;
										SET POR=TOT-POR;
										SET CAMBIO=POR-pcantidad;

										update ventas set estado=0 where id_cuenta=IDC and estado=1;	
										update complementos set estado=0 where id_cuenta=IDC and estado=1;
										update ventasB set estado=0 where id_cuenta=IDC and estado=1;	

										if CAMBIO > 0 then
											update cuentas set total=total+pcantidad where id_cuenta=IDC;
											update tickets set total=total+pcantidad where id_ticket=IDT;
											update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
											update cuentas set estado=2 where id_cuenta=IDC;	
											update cuentas set subtotal=CAMBIO where id_cuenta=IDC;
											update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
											update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
											insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
											select 'Cuenta no pagada' as mensaje;

										else
											update tickets set total=total+POR where id_ticket=IDT;
											update cuentas set total=POR where id_cuenta=IDC;
											update cuentas set total_c=POR where id_cuenta=IDC;
                                            select subtotal into SUBS from cuentas where id_cuenta=IDC;
                                            update tickets set subtotal=subtotal-SUBS where id_ticket=IDT;
											update cuentas set subtotal=0 where id_cuenta=IDC;	
											update cuentas set estado=0 where id_cuenta=IDC;	
											update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
											insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
			                                
			                                    if CAMBIO=0 then
													select 'Cuenta Pagada' as mensaje;
			                                    else								
													select CONCAT('El cambio es:', ABS(CAMBIO));	
			                                    end if;
										end if;
									else 
										select count(id_cuenta) into CONT2 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=1 and tickets.estado=1 and cuentas.id_ticket=IDT;
										if CONT2 > 1 then 

											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
											select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;

											SET TOT=TOTV+TOTC+TOTB;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update ventas set estado=0 where id_cuenta=IDC and estado=1;	
											update complementos set estado=0 where id_cuenta=IDC and estado=1;
											update ventasB set estado=0 where id_cuenta=IDC and estado=1;	

											if CAMBIO > 0 then
												update cuentas set total=total+pcantidad where id_cuenta=IDC;
												update tickets set total=total+pcantidad where id_ticket=IDT;
												update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
												update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
												update cuentas set estado=2 where id_cuenta=IDC;	
												update cuentas set subtotal=CAMBIO where id_cuenta=IDC;
                                                update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
												update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
												select 'Cuenta no pagada' as mensaje;

											else
												update tickets set total=total+POR where id_ticket=IDT;
												update cuentas set total=POR where id_cuenta=IDC;
												update cuentas set total_c=POR where id_cuenta=IDC;
												select subtotal into SUBS from cuentas where id_cuenta=IDC;
												update tickets set subtotal=subtotal-SUBS where id_ticket=IDT;
												update cuentas set subtotal=0 where id_cuenta=IDC;	
												update cuentas set estado=0 where id_cuenta=IDC;	
												update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
				                                
				                                    if CAMBIO=0 then
														select 'Cuenta Pagada' as mensaje;
				                                    else								
														select CONCAT('El cambio es:', ABS(CAMBIO));	
				                                    end if;
											end if;
										else
											select IF(ISNULL(sum(ventas.subtotal)),0,sum(ventas.subtotal)) into TOTV  from ventas,tickets,locaciones,cuentas where ventas.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventas.id_cuenta=IDC and ventas.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;					
											select IF(ISNULL(sum(complementos.subtotal)),0,sum(complementos.subtotal)) into TOTC from complementos,tickets,locaciones,cuentas where complementos.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and complementos.id_cuenta=IDC and complementos.id_cuenta=cuentas.id_cuenta and locaciones.id_ticket=tickets.id_ticket and cuentas.id_ticket=tickets.id_ticket;	
											select IF(ISNULL(sum(ventasB.subtotal)),0,sum(ventasB.subtotal)) into TOTB  from ventasB,tickets,locaciones,cuentas where ventasB.estado=1 and locaciones.estado=2 and tickets.estado=1 and cuentas.estado=1 and ventasB.id_cuenta=IDC and ventasB.id_cuenta=cuentas.id_cuenta and tickets.id_ticket=locaciones.id_ticket and cuentas.id_ticket=tickets.id_ticket;

											SET TOT=TOTV+TOTC+TOTB;
											select monto into POR from descuentos where id_descuento=pid_descuento;
											SET POR=POR/100;
											SET POR=TOT*POR;
											SET POR=TOT-POR;
											SET CAMBIO=POR-pcantidad;

											update ventas set estado=0 where id_cuenta=IDC and estado=1;	
											update complementos set estado=0 where id_cuenta=IDC and estado=1;
											update ventasB set estado=0 where id_cuenta=IDC and estado=1;
												
												if CAMBIO > 0 then
													update cuentas set total=total+pcantidad where id_cuenta=IDC;
                                                    update tickets set total=total+pcantidad where id_ticket=IDT;
													update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
													update cuentas set estado=2 where id_cuenta=IDC;	
													update cuentas set subtotal=CAMBIO where id_cuenta=IDC;	
                                                    update tickets set subtotal=(subtotal-TOT)+ABS(CAMBIO) where id_ticket=IDT;
													update tickets set id_empleado=pid_empleado where id_ticket=IDT;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
													select 'Cuenta no pagada' as mensaje;

												else
													update tickets set total=total+POR where id_ticket=IDT;
                                                    update cuentas set total=POR where id_cuenta=IDC;
													update cuentas set total_c=POR where id_cuenta=IDC;
													select id_locacion into IDL from cuentas where id_cuenta=IDC;
													update locaciones set estado=1 where id_locacion=IDL;
													update locaciones set id_ticket=0 where id_locacion=IDL;	
													update tickets set subtotal=0 where id_ticket=IDT;
													update cuentas set subtotal=0 where id_cuenta=IDC;	
													update tickets set estado=0 where id_ticket=IDT;
													update cuentas set estado=0 where id_cuenta=IDC;	
													update tickets set id_empleado=pid_empleado where id_ticket=IDT;		
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);	
			                                            if CAMBIO=0 then
															select 'Locacion Pagada' as mensaje;
			                                            else								
															select CONCAT('El cambio es:', ABS(CAMBIO));	
			                                            end if;
												end if;
										end if;	
									end if;
								else

									if ESC = 2 then
										select count(id_cuenta) into CONT3 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=1 and tickets.estado=1 and cuentas.id_ticket=IDT;
										if CONT3 > 0 then
											select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
											select monto into POR from descuentos where id_descuento=pid_descuento;

											SET POR=POR/100;
											SET POR=DEUDA*POR;											
											SET POR=DEUDA-POR;
											SET TOTD=POR-pcantidad;

											if TOTD > 0 then
												update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
												update cuentas set total=total+pcantidad where id_cuenta=IDC;
												update tickets set total=total+pcantidad where id_ticket=IDT;
                                                select subtotal into SUBS from cuentas where id_cuenta=IDC;
												update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
												update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;	
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
												select 'Cuenta no pagada' as mensaje;
											else
												update cuentas set total_c=total_c+POR where id_cuenta=IDC;
												update cuentas set total=total+POR where id_cuenta=IDC;
												update tickets set total=total+POR where id_ticket=IDT;
												update tickets set subtotal=0 where id_ticket=IDT;
												update cuentas set subtotal=0 where id_cuenta=IDC;
												update cuentas set estado=0 where id_cuenta=IDC;	
												insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                       	    if TOTD=0 then
														select 'Locacion pagada' as mensaje;
						                            else    
														select CONCAT('El cambio es:', abs(TOTD));	
													end if;
											end if;
										else
											select count(id_cuenta) into CONT4 from cuentas,tickets where cuentas.id_ticket=tickets.id_ticket and cuentas.estado=2 and tickets.estado=1 and cuentas.id_ticket=IDT;
											if CONT4 > 1 then
												select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
												select monto into POR from descuentos where id_descuento=pid_descuento;

												SET POR=POR/100;
												SET POR=DEUDA*POR;											
												SET POR=DEUDA-POR;
												SET TOTD=POR-pcantidad;

												if TOTD > 0 then
													update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
													update cuentas set total=total+pcantidad where id_cuenta=IDC;
													update tickets set total=total+pcantidad where id_ticket=IDT;
                                                    select subtotal into SUBS from cuentas where id_cuenta=IDC;
													update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
													update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
													select 'Cuenta no pagada' as mensaje;
												else
													update cuentas set total_c=total_c+POR where id_cuenta=IDC;
													update cuentas set total=total+POR where id_cuenta=IDC;
													update tickets set total=total+POR where id_ticket=IDT;
													update tickets set subtotal=0 where id_ticket=IDT;
													update cuentas set subtotal=0 where id_cuenta=IDC;
													update cuentas set estado=0 where id_cuenta=IDC;	
													insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                        	    if TOTD=0 then
															select 'Locacion pagada' as mensaje;
						                                else    
															select CONCAT('El cambio es:', abs(TOTD));	
														end if;
												end if;
											else

												select subtotal into DEUDA from cuentas where id_cuenta=IDC and estado=2;
												select monto into POR from descuentos where id_descuento=pid_descuento;

												SET POR=POR/100;
												SET POR=DEUDA*POR;											
												SET POR=DEUDA-POR;
												SET TOTD=POR-pcantidad;

													if TOTD > 0 then
														update cuentas set total_c=total_c+pcantidad where id_cuenta=IDC;
														update cuentas set total=total+pcantidad where id_cuenta=IDC;
														update tickets set total=total+pcantidad where id_ticket=IDT;
                                                        select subtotal into SUBS from cuentas where id_cuenta=IDC;
														update cuentas set subtotal=(subtotal-SUBS)+TOTD where id_cuenta=IDC and estado=2;
														update tickets set subtotal=(subtotal-SUBS)+TOTD where id_ticket=IDT;	
														insert 	into metodos_p values(null,pid_mp,IDT,IDC);		
													    select 'Cuenta no pagada' as mensaje;
													else
														update cuentas set total_c=total_c+POR where id_cuenta=IDC;
														update cuentas set total=total+POR where id_cuenta=IDC;
														update tickets set total=total+POR where id_ticket=IDT;
														update tickets set subtotal=0 where id_ticket=IDT;
														update cuentas set subtotal=0 where id_cuenta=IDC;	
														update tickets set estado=0 where id_ticket=IDT;
														update cuentas set estado=0 where id_cuenta=IDC;
                                                        select id_locacion into IDLD from locaciones where id_ticket=IDT and estado=2;
														update locaciones set estado=1 where id_locacion=IDLD;
														update locaciones set id_ticket=0 where id_locacion=IDLD;
														insert 	into metodos_p values(null,pid_mp,IDT,IDC);
						                                   if TOTD=0 then
																select 'Locacion pagada' as mensaje;
						                                    else    
																select CONCAT('El cambio es:', abs(TOTD));	
															end if;
													end if;
											end if;
										end if;
									else

										if ESC = 3 then
											select 'La cuenta ha sido cancelada' as mensaje;
										else

											if ESC = 0 then
												select 'La cuenta ha sido pagada' as mensaje;
											else
												select 'Error en la cuenta' as mensaje;
											end if;
										end if;
									end if;
								end if;
							else 
							select 'El empleado no existe' as mensaje;
							end if;	
						end if;		
						
					else
					select 'El metodo de pago no existe' as mensaje;
					end if;
			else
			select 'El ticket no existe' as mensaje;
			end if;
			
		else
		select 'La cuenta no existe' as mensaje;
		end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RESERVA_C` (IN `pid_locacion` INT)  BEGIN
	DECLARE IDL INT;
	DECLARE EL INT;
	DECLARE IDT INT;
	DECLARE INS INT;
	DECLARE ESI INT;

	SET IDL=0;
	SET EL=0;
	SET IDT=0;
	SET INS=0;
	SET ESI=0;

			select max(id_sesion) into INS from t_sesiones;	
			select	estado_i into ESI from t_sesiones where estado_c=2 and id_sesion=INS;
			if ESI = 1 THEN

				select id_locacion into IDL from locaciones where id_locacion=pid_locacion;
				if IDL > 0 THEN

					select estado into EL from locaciones where id_locacion=pid_locacion;
					if EL = 1 then

						insert into tickets values (null,0,0,now(),0,1,0);
						select MAX(id_ticket) into IDT from tickets;
						update locaciones set id_ticket=IDT,estado=2 where id_locacion=pid_locacion;
						insert into cuentas values(null,1,pid_locacion,IDT,1,0,0,0,0,now());	
						select 'Reservacion Exitosa' as mensaje;

					else
					select 'La locacion se encuentra ocupada' as mensaje;
					end if;

				else
				select 'La locacion no existe' as mensaje;
				end if;

			else
			select 'El corte se ha hecho porfavor cierra e inicia sesion de nuevo' as mensaje;
			end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RESTARI` (IN `pid_ingrediente` INT, IN `pcantidad` FLOAT)  BEGIN

	DECLARE IDI INT;
	DECLARE CANI FLOAT;

	SET IDI=0;
	SET CANI=0;
	
		select id_ingrediente into IDI from ingredientes where id_ingrediente=pid_ingrediente;
		if IDI > 0 then
			select cantidad into CANI from ingredientes where id_ingrediente=IDI;
			if CANI > pcantidad then
				update ingredientes set cantidad=cantidad-pcantidad where id_ingrediente=IDI;
				select 'Ingredientes Removidos' as mensaje;	
			else
				select 'La cantidad a remover no puede ser mayor al stock' as mensaje;
			end if;
		else
			select 'El ingrediente no existe' as mensaje;
		end if;	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RESTARIV` (IN `pid_venta` INT, IN `pid_ingrediente` INT, IN `pcantidad` FLOAT)  BEGIN

	DECLARE IDV INT;	
	DECLARE IDI INT;
	DECLARE CANI FLOAT;

	SET IDV=0;
	SET IDI=0;
	SET CANI=0;

	select id_venta into IDV from ventas where id_venta=pid_venta;
	if IDV > 0 then
		select id_ingrediente into IDI from ingredientes where id_ingrediente=pid_ingrediente;
		if IDI > 0 then
			select cantidad into CANI from ingredientes where id_ingrediente=IDI;
			if CANI > pcantidad then
				update ingredientes set cantidad=cantidad-pcantidad where id_ingrediente=IDI;
				select 'ingredientes Removidos' as mensaje;	
			else
				select 'La cantidad a remover no puede ser mayor al stock' as mensaje;
			end if;
		else
			select 'El ingrediente no existe' as mensaje;
		end if;
	else
		select 'La venta no existe' as mensaje;
	end if;		
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id_alimento` int(11) NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Precio` float DEFAULT NULL,
  `id_categoria_a` int(11) DEFAULT NULL,
  `id_tipo_de_a` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `cantidad_p` float DEFAULT NULL,
  `id_ingrediente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id_alimento`, `Descripcion`, `Precio`, `id_categoria_a`, `id_tipo_de_a`, `estado`, `cantidad_p`, `id_ingrediente`) VALUES
(1, 'Ensalada de atun', 80, 1, 1, 1, 0, 1),
(2, 'Ensalada Pizzanlov', 80, 1, 1, 1, 0, 1),
(3, 'Tabla de carnes frias', 140, 2, 1, 1, 0, 1),
(4, 'Tabla de quesos', 140, 2, 1, 1, 0, 1),
(5, 'Nuggets de pollo con papas', 75, 2, 1, 1, 250, 11),
(6, 'Dedos de queso con papas', 75, 2, 1, 1, 200, 11),
(7, 'Papas a la francesa 250gr', 35, 2, 1, 1, 250, 11),
(8, 'Papas a la francesa 500gr', 55, 2, 1, 1, 500, 11),
(9, 'Alitas media orden', 65, 3, 1, 1, 0, 19),
(10, 'Alitas una orden', 110, 3, 1, 1, 0, 19),
(11, 'Alitas orden doble', 220, 3, 1, 1, 0, 19),
(12, 'Pizza de queso', 110, 4, 1, 1, 0, 1),
(13, 'Pizza de peporoni', 130, 4, 1, 1, 0, 1),
(14, 'Pizza hawaiana', 130, 4, 1, 1, 0, 1),
(15, 'Pizza margarita', 125, 4, 1, 1, 0, 1),
(16, 'Pizza vegetariana', 135, 4, 1, 1, 0, 1),
(17, 'Pizza pastor', 160, 4, 1, 1, 0, 1),
(18, 'Pizza napolitana', 165, 4, 1, 1, 0, 1),
(19, 'Pizza pera y brie', 160, 4, 1, 1, 0, 1),
(20, 'Pizza 4 quesos', 170, 4, 1, 1, 0, 1),
(21, 'Pizza pizzanlov', 175, 4, 1, 1, 0, 1),
(22, 'Pizza verde', 170, 4, 1, 1, 0, 1),
(23, 'Tu pizza', 185, 4, 1, 1, 0, 1),
(24, 'Pizza de nutella y fruta', 45, 5, 1, 1, 0, 1),
(25, 'Pizza de mermelada y queso brie', 45, 5, 1, 1, 0, 1),
(26, 'Pasteleria de la casa', 50, 5, 1, 1, 0, 1),
(27, 'Helados', 30, 5, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bcom`
--

CREATE TABLE `bcom` (
  `id_Bcom` int(11) NOT NULL,
  `id_complementoN` int(11) DEFAULT NULL,
  `id_cuentaN` int(11) DEFAULT NULL,
  `descripcionN` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcionO` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precioN` float DEFAULT NULL,
  `precioO` float DEFAULT NULL,
  `cantidadN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bcom`
--

INSERT INTO `bcom` (`id_Bcom`, `id_complementoN`, `id_cuentaN`, `descripcionN`, `descripcionO`, `precioN`, `precioO`, `cantidadN`, `cantidadO`, `subtotalN`, `subtotalO`, `fecha`, `id_usuarioN`) VALUES
(1, 1, 6, 'moneral preparado', 'moneral preparado', 25, 25, 2, 1, 50, 25, '2018-06-12 14:44:37', 2),
(2, 1, 6, 'moneral preparado', 'moneral preparado', 25, 25, 2, 2, 50, 50, '2018-06-12 14:44:54', 2),
(3, 1, 6, 'moneral preparado', 'moneral preparado', 25, 25, 1, 2, 25, 50, '2018-06-12 14:45:11', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bcomc`
--

CREATE TABLE `bcomc` (
  `id_BcomC` int(11) NOT NULL,
  `id_complementoN` int(11) DEFAULT NULL,
  `id_cuentaN` int(11) DEFAULT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas`
--

CREATE TABLE `bebidas` (
  `id_bebida` int(11) NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Precio` float DEFAULT NULL,
  `id_categoria_a` int(11) DEFAULT NULL,
  `id_tipo_de_a` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `cantidad_p` float DEFAULT NULL,
  `id_ingrediente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bebidas`
--

INSERT INTO `bebidas` (`id_bebida`, `Descripcion`, `Precio`, `id_categoria_a`, `id_tipo_de_a`, `estado`, `cantidad_p`, `id_ingrediente`) VALUES
(1, 'Cafe expreso', 25, 6, 1, 1, 0, 1),
(2, 'Cafe americano', 25, 6, 1, 1, 0, 1),
(3, 'Cafe late', 35, 6, 1, 1, 0, 1),
(4, 'Cafe capuchino', 35, 6, 1, 1, 0, 1),
(5, 'Cafe mocachino', 35, 6, 1, 1, 0, 1),
(6, 'Cafe frapuchino', 35, 6, 1, 1, 0, 1),
(7, 'Cafe affogato', 45, 6, 1, 1, 0, 1),
(8, 'Cafe chocolate BAILEYS', 105, 6, 1, 1, 0, 1),
(9, 'Cerveza corona', 30, 7, 1, 1, 1, 12),
(10, 'Cerveza victoria', 30, 7, 1, 1, 1, 13),
(11, 'Cerveza pacifico', 30, 7, 1, 1, 1, 14),
(12, 'Cerveza leon', 30, 7, 1, 1, 1, 15),
(13, 'Michelada (corona, victoria, pacifico,leon)', 35, 7, 1, 1, 0, 1),
(14, 'Cubana (corona, victoria, pacifico,leon)', 40, 7, 1, 1, 0, 1),
(15, 'Clamato (corona, victoria, pacifico,leon)', 45, 7, 1, 1, 0, 1),
(16, 'Cerveza Modelo especial', 35, 7, 1, 1, 1, 16),
(17, 'Cerveza Negra modelo', 35, 7, 1, 1, 1, 17),
(18, 'Cerveza corona light', 35, 7, 1, 1, 1, 18),
(19, 'Cerveza Michelada', 40, 7, 1, 1, 0, 1),
(20, 'Cerveza Cubana', 45, 7, 1, 1, 0, 1),
(21, 'Cerveza Clamato', 50, 7, 1, 1, 0, 1),
(22, 'Coca cola', 20, 7, 1, 1, 1, 2),
(23, 'Coca cola light', 20, 7, 1, 1, 1, 3),
(24, 'fresca', 20, 7, 1, 1, 1, 4),
(25, 'sprite', 20, 7, 1, 1, 1, 5),
(26, 'sprite zero', 20, 7, 1, 1, 1, 6),
(27, 'sidral', 20, 7, 1, 1, 1, 7),
(28, 'fanta', 20, 7, 1, 1, 1, 8),
(29, 'delaware', 20, 7, 1, 1, 1, 9),
(30, 'ginger ale', 20, 7, 1, 1, 1, 1),
(31, 'Botella de agua', 20, 7, 1, 1, 1, 10),
(32, 'Canica', 30, 7, 1, 1, 0, 1),
(33, 'Conga', 35, 7, 1, 1, 0, 1),
(34, 'Clamato preparado', 35, 7, 1, 1, 0, 1),
(35, 'Limonada o Naranjada', 30, 7, 1, 1, 0, 1),
(36, 'Malteada', 40, 7, 1, 1, 0, 1),
(37, 'Frappe', 35, 7, 1, 1, 0, 1),
(38, 'Chocolate', 30, 7, 1, 1, 0, 1),
(39, 'Leche', 25, 7, 1, 1, 0, 1),
(40, 'Centenario Plata', 60, 8, 1, 1, 0, 20),
(41, 'Centenario Reposado', 60, 8, 1, 1, 0, 21),
(42, 'Don Julio', 90, 8, 1, 1, 0, 22),
(43, 'Don Julio 70', 105, 8, 1, 1, 0, 23),
(44, 'Herradura Blanco', 80, 8, 1, 1, 0, 24),
(45, 'Herradura Plata', 80, 8, 1, 1, 0, 25),
(46, 'Herradura Reposado', 90, 8, 1, 1, 0, 26),
(47, 'Jose Cuervo', 60, 8, 1, 1, 0, 27),
(48, 'Tradicional', 70, 8, 1, 1, 0, 28),
(49, '1800', 70, 8, 1, 1, 0, 29),
(50, '800 Reposado', 75, 8, 1, 1, 0, 30),
(51, 'Mezcla Peloton', 75, 8, 1, 1, 0, 1),
(52, 'Etiqueta Negra', 125, 9, 1, 1, 0, 1),
(53, 'Etiqueta Roja', 85, 9, 1, 1, 0, 1),
(54, 'Buchanans', 125, 9, 1, 1, 0, 31),
(55, 'Jack Daniels', 85, 9, 1, 1, 0, 32),
(56, 'JB', 80, 9, 1, 1, 0, 33),
(57, 'Absolut Azul', 80, 10, 1, 1, 0, 34),
(58, 'Grey Goose', 95, 10, 1, 1, 0, 1),
(59, 'Stolichnaya', 80, 10, 1, 1, 0, 35),
(60, 'Appleton Blanco', 65, 11, 1, 1, 0, 36),
(61, 'Appleton Especial', 65, 11, 1, 1, 0, 37),
(62, 'Bacardi Añejo', 65, 11, 1, 1, 0, 38),
(63, 'Bacardi Blanco', 65, 11, 1, 1, 0, 39),
(64, 'Bacardi Limon', 70, 11, 1, 1, 0, 40),
(65, 'Bacardi Razz', 70, 11, 1, 1, 0, 41),
(66, 'Flor de Caña', 65, 11, 1, 1, 0, 42),
(67, 'Havana Club', 65, 11, 1, 1, 0, 43),
(68, 'Malibu', 70, 11, 1, 1, 0, 44),
(69, 'Matesalem Platino', 70, 11, 1, 1, 0, 45),
(70, 'Azteca de Oro', 65, 12, 1, 1, 0, 46),
(71, 'Don Pedro', 60, 12, 1, 1, 0, 47),
(72, 'Fundador', 70, 12, 1, 1, 0, 48),
(73, 'Terry', 75, 12, 1, 1, 0, 49),
(74, 'Torres 10', 75, 12, 1, 1, 0, 50),
(75, 'Hennessy VSOP', 140, 12, 1, 1, 0, 51),
(76, 'Beefeater', 85, 13, 1, 1, 0, 52),
(77, 'Larios', 70, 13, 1, 1, 0, 1),
(78, 'Agavero', 65, 14, 1, 1, 0, 54),
(79, 'Amaretto Disarono', 85, 14, 1, 1, 0, 55),
(80, 'Anis Chinchon Dulce', 65, 14, 1, 1, 0, 56),
(81, 'Anis Chinchon Seco', 65, 14, 1, 1, 0, 57),
(82, 'Baileys', 85, 14, 1, 1, 0, 58),
(83, 'Licor de Pacharan', 75, 14, 1, 1, 0, 59),
(84, 'Campari', 65, 14, 1, 1, 0, 60),
(85, 'Dubo nnet', 65, 14, 1, 1, 0, 61),
(86, 'Frangelico', 85, 14, 1, 1, 0, 62),
(87, 'Jagermaister', 85, 14, 1, 1, 0, 63),
(88, 'Kahlua', 55, 14, 1, 1, 0, 64),
(89, 'Licor 43', 95, 14, 1, 1, 0, 65),
(90, 'Midori', 70, 14, 1, 1, 0, 66),
(91, 'Sambuca Negro', 85, 14, 1, 1, 0, 67),
(92, 'Vermounth Rojo', 60, 14, 1, 1, 0, 68),
(93, 'Copa de Vino', 60, 15, 1, 1, 0, 69),
(94, 'Bloody Mary', 85, 16, 1, 1, 0, 1),
(95, 'Caipirinha', 85, 16, 1, 1, 0, 1),
(96, 'Mojito', 105, 16, 1, 1, 0, 1),
(97, 'Daikiri', 90, 16, 1, 1, 0, 1),
(98, 'Margarita', 105, 16, 1, 1, 0, 1),
(99, 'Martini', 105, 16, 1, 1, 0, 1),
(100, 'Paloma', 90, 16, 1, 1, 0, 1),
(101, 'Piña colada', 85, 16, 1, 1, 0, 1),
(102, 'Sol y sombra', 95, 16, 1, 1, 0, 1),
(103, 'frappes', 40, 6, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoracor`
--

CREATE TABLE `bitacoracor` (
  `id_bitacora` int(11) NOT NULL,
  `total_c` float DEFAULT NULL,
  `c_efectivo` float DEFAULT NULL,
  `c_credito` float DEFAULT NULL,
  `cantidad_i` float DEFAULT NULL,
  `ganancia` float DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_corte` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bitacoracor`
--

INSERT INTO `bitacoracor` (`id_bitacora`, `total_c`, `c_efectivo`, `c_credito`, `cantidad_i`, `ganancia`, `fecha_inicio`, `fecha_corte`, `id_usuario`) VALUES
(1, 3695, 2295, 735, 1000, 2695, '2018-06-11 17:42:19', '2018-06-12 19:44:28', 2),
(2, 1670, 670, 0, 1000, 670, '2018-06-13 17:00:28', '2018-06-13 19:53:07', 2),
(3, 7540, 4795, 2145, 1000, 6540, '2018-06-16 18:26:28', '2018-06-19 19:40:17', 2),
(4, 2450, 1210, 240, 1000, 1450, '2018-06-19 19:40:54', '2018-06-19 20:13:48', 2),
(5, 1000, 0, 0, 1000, 0, '2018-06-23 18:38:07', '2018-06-23 18:38:32', 2),
(6, 5161, 2801, 1360, 1000, 4161, '2018-06-23 18:39:07', '2018-06-23 19:20:05', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacorain`
--

CREATE TABLE `bitacorain` (
  `id_ingredienteO` int(11) NOT NULL,
  `DescripcionO` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cantidadO` float DEFAULT NULL,
  `estadoO` int(11) DEFAULT NULL,
  `fecha_cO` date DEFAULT NULL,
  `estado_cO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventas`
--

CREATE TABLE `bventas` (
  `id_Bventa` int(11) NOT NULL,
  `id_ventaN` int(11) DEFAULT NULL,
  `id_cuentaN` int(11) DEFAULT NULL,
  `cantidadN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `id_alimentoN` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bventas`
--

INSERT INTO `bventas` (`id_Bventa`, `id_ventaN`, `id_cuentaN`, `cantidadN`, `cantidadO`, `id_alimentoN`, `subtotalN`, `subtotalO`, `fecha`, `id_usuarioN`) VALUES
(1, 12, 10, 1, 1, 14, 130, 130, '2018-06-12 17:51:35', 2),
(2, 12, 10, 1, 1, 14, 130, 130, '2018-06-12 17:51:57', 2),
(3, 11, 10, 1, 1, 10, 110, 110, '2018-06-12 17:52:10', 2),
(4, 14, 12, 2, 1, 26, 100, 50, '2018-06-12 19:42:59', 2),
(5, 25, 19, 4, 3, 10, 440, 330, '2018-06-16 18:40:55', 2),
(6, 50, 29, 5, 2, 9, 325, 130, '2018-06-18 14:25:36', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventasb`
--

CREATE TABLE `bventasb` (
  `id_Bventab` int(11) NOT NULL,
  `id_ventaBN` int(11) DEFAULT NULL,
  `id_cuentabN` int(11) DEFAULT NULL,
  `cantidadbN` int(11) DEFAULT NULL,
  `cantidadbO` int(11) DEFAULT NULL,
  `id_bebidaN` int(11) DEFAULT NULL,
  `subtotalN` float DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bventasb`
--

INSERT INTO `bventasb` (`id_Bventab`, `id_ventaBN`, `id_cuentabN`, `cantidadbN`, `cantidadbO`, `id_bebidaN`, `subtotalN`, `subtotalO`, `fecha`, `id_usuarioN`) VALUES
(1, 44, 31, 2, 2, 31, 40, 40, '2018-06-18 15:08:31', 2),
(2, 46, 33, 6, 4, 31, 120, 80, '2018-06-18 15:39:26', 2),
(3, 47, 35, 4, 2, 31, 80, 40, '2018-06-18 15:48:10', 2),
(4, 47, 35, 2, 4, 31, 40, 80, '2018-06-18 15:48:16', 2),
(5, 60, 44, 1, 1, 35, 30, 30, '2018-06-19 20:06:38', 2),
(6, 60, 44, 1, 1, 35, 30, 30, '2018-06-19 20:07:05', 2),
(7, 61, 44, 1, 1, 13, 35, 35, '2018-06-19 20:07:37', 2),
(8, 60, 44, 2, 1, 35, 60, 30, '2018-06-19 20:08:02', 2),
(9, 63, 45, 1, 2, 31, 20, 40, '2018-06-19 20:13:05', 2),
(10, 80, 54, 10, 5, 31, 200, 100, '2018-06-23 19:06:27', 2),
(11, 80, 54, 5, 10, 31, 100, 200, '2018-06-23 19:06:41', 2),
(12, 82, 55, 2, 1, 13, 70, 35, '2018-06-23 19:09:30', 2),
(13, 82, 55, 3, 2, 13, 105, 70, '2018-06-23 19:09:31', 2),
(14, 82, 55, 1, 3, 13, 35, 105, '2018-06-23 19:09:41', 2),
(15, 83, 55, 2, 1, 22, 40, 20, '2018-06-23 19:10:07', 2),
(16, 83, 55, 1, 2, 22, 20, 40, '2018-06-23 19:10:21', 2),
(17, 86, 56, 4, 2, 32, 120, 60, '2018-06-23 19:14:03', 2),
(18, 86, 56, 2, 4, 32, 60, 120, '2018-06-23 19:14:13', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventasc`
--

CREATE TABLE `bventasc` (
  `id_BventasC` int(11) NOT NULL,
  `id_ventaN` int(11) DEFAULT NULL,
  `id_cuentaN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `id_alimentoN` int(11) DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bventasc`
--

INSERT INTO `bventasc` (`id_BventasC`, `id_ventaN`, `id_cuentaN`, `cantidadO`, `id_alimentoN`, `subtotalO`, `fecha`, `id_usuarioN`) VALUES
(1, 51, 30, 4, 11, 880, '2018-06-18 15:08:59', 2),
(2, 50, 29, 5, 9, 325, '2018-06-18 15:41:11', 2),
(3, 49, 29, 3, 5, 225, '2018-06-18 15:41:20', 2),
(4, 68, 53, 1, 11, 220, '2018-06-23 18:59:04', 2),
(5, 77, 56, 1, 11, 220, '2018-06-23 19:15:22', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventascb`
--

CREATE TABLE `bventascb` (
  `id_BventasC` int(11) NOT NULL,
  `id_ventaBN` int(11) DEFAULT NULL,
  `id_cuentaN` int(11) DEFAULT NULL,
  `cantidadO` int(11) DEFAULT NULL,
  `id_bebidaN` int(11) DEFAULT NULL,
  `subtotalO` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_usuarioN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bventascb`
--

INSERT INTO `bventascb` (`id_BventasC`, `id_ventaBN`, `id_cuentaN`, `cantidadO`, `id_bebidaN`, `subtotalO`, `fecha`, `id_usuarioN`) VALUES
(1, 7, 3, 1, 37, 35, '2018-06-11 18:28:05', 2),
(2, 11, 9, 1, 35, 30, '2018-06-12 17:44:34', 2),
(3, 18, 13, 1, 37, 35, '2018-06-13 17:03:36', 2),
(4, 43, 29, 2, 32, 60, '2018-06-18 14:18:44', 2),
(5, 46, 33, 6, 31, 120, '2018-06-18 15:40:09', 2),
(6, 45, 32, 2, 31, 40, '2018-06-18 15:40:50', 2),
(7, 44, 31, 2, 31, 40, '2018-06-18 15:41:03', 2),
(8, 47, 35, 2, 31, 40, '2018-06-18 15:48:26', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_a`
--

CREATE TABLE `categorias_a` (
  `id_categoria_a` int(11) NOT NULL,
  `descripcion` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `tipo_c` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias_a`
--

INSERT INTO `categorias_a` (`id_categoria_a`, `descripcion`, `estado`, `tipo_c`) VALUES
(1, 'Ensaladas', 1, 1),
(2, 'Botana', 1, 1),
(3, 'Alitas', 1, 1),
(4, 'Pizza', 1, 1),
(5, 'Postre', 1, 1),
(6, 'Cafe', 1, 2),
(7, 'Bebida', 1, 2),
(8, 'Tequila y Mezcales', 1, 2),
(9, 'Whisky', 1, 2),
(10, 'Vodka', 1, 2),
(11, 'Ron', 1, 2),
(12, 'Brandy y Cognac', 1, 2),
(13, 'Ginebra', 1, 2),
(14, 'Licores', 1, 2),
(15, 'Vino', 1, 2),
(16, 'Cocteles', 1, 2),
(17, 'Sugerencias', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `complementos`
--

CREATE TABLE `complementos` (
  `id_complemento` int(11) NOT NULL,
  `id_cuenta` int(11) DEFAULT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_v` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `complementos`
--

INSERT INTO `complementos` (`id_complemento`, `id_cuenta`, `descripcion`, `precio`, `cantidad`, `subtotal`, `estado`, `id_usuario`, `tipo_v`) VALUES
(1, 6, 'moneral preparado', 25, 1, 25, 0, 2, 2),
(2, 7, 'Pizza Napolitana Pizzanliv', 175, 1, 175, 0, 2, 2),
(3, 8, 'Pizza Peperoni Verde', 170, 1, 170, 0, 2, 2),
(4, 11, 'pizza napolitana peperoni', 165, 1, 165, 0, 2, 2),
(5, 13, 'pizza verde', 170, 1, 170, 0, 2, 2),
(6, 16, 'Frappe Oreo', 40, 1, 40, 0, 2, 2),
(7, 18, 'Media Pastor', 90, 1, 90, 0, 2, 2),
(8, 19, 'Pizza Pizzanlov Pastor', 175, 1, 175, 0, 2, 2),
(9, 19, 'Pizza Peperoni Pizzanlov', 175, 1, 175, 0, 2, 2),
(10, 19, 'Pizza Peperoni Pera y Brie', 160, 1, 160, 0, 2, 2),
(11, 24, 'Copa Vino Tinto', 60, 1, 60, 0, 2, 2),
(12, 24, 'Pizza Hawaiana Pizzanlov', 175, 1, 175, 0, 2, 2),
(13, 24, 'Tu Pizza', 185, 1, 185, 0, 2, 2),
(14, 25, 'Mocachino', 35, 1, 35, 0, 2, 2),
(15, 27, 'Pizza 4Quesos Queso', 170, 1, 170, 0, 2, 2),
(16, 28, 'Pizza Noruega', 170, 1, 170, 0, 2, 2),
(17, 40, 'Pizza Hawaiana Peperoni', 130, 1, 130, 0, 2, 2),
(18, 41, 'Frappe Nutella', 40, 1, 40, 0, 2, 2),
(19, 48, 'Pizza Peperoni Vege', 135, 1, 135, 0, 2, 2),
(20, 50, 'Pizza Vegetariana', 135, 1, 135, 0, 2, 2),
(21, 52, 'pizza napolitana peperoni', 165, 1, 165, 0, 2, 2),
(22, 54, 'Pizza Peperoni Vege', 135, 1, 135, 0, 2, 2);

--
-- Disparadores `complementos`
--
DELIMITER $$
CREATE TRIGGER `Bc` AFTER UPDATE ON `complementos` FOR EACH ROW BEGIN			
		if new.estado = 2 then            
		INSERT INTO BcomC values(null,new.id_complemento,new.id_cuenta,new.descripcion,new.precio,new.cantidad,new.subtotal,now(),new.id_usuario);
           	else				
			if new.estado = 1 then                
			INSERT INTO Bcom values(null,new.id_complemento,new.id_cuenta,new.descripcion,old.descripcion,new.precio,old.precio,new.cantidad,old.cantidad,new.subtotal,old.subtotal,now(),new.id_usuario);                
			end if;           
		end if;        
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id_cuenta` int(11) NOT NULL,
  `descripcion` int(11) DEFAULT NULL,
  `id_locacion` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `total_e` float DEFAULT NULL,
  `total_c` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id_cuenta`, `descripcion`, `id_locacion`, `id_ticket`, `estado`, `subtotal`, `total`, `total_e`, `total_c`, `fecha`) VALUES
(1, 1, 2, 1, 0, 0, 185, 185, 0, '2018-06-11 17:45:15'),
(2, 1, 5, 2, 0, 0, 470, 0, 470, '2018-06-11 18:12:35'),
(3, 1, 5, 3, 0, 0, 225, 225, 0, '2018-06-11 18:24:40'),
(4, 1, 3, 4, 3, 0, 0, 0, 0, '2018-06-11 19:09:16'),
(5, 2, 3, 4, 3, 0, 0, 0, 0, '2018-06-11 19:09:31'),
(6, 1, 1, 5, 0, 0, 285, 285, 0, '2018-06-12 14:27:20'),
(7, 1, 12, 6, 0, 0, 265, 0, 265, '2018-06-12 17:29:46'),
(8, 1, 5, 7, 0, 0, 335, 335, 0, '2018-06-12 17:35:56'),
(9, 1, 14, 8, 0, 0, 210, 210, 0, '2018-06-12 17:40:49'),
(10, 1, 11, 9, 0, 0, 300, 300, 0, '2018-06-12 17:49:26'),
(11, 1, 5, 10, 0, 0, 260, 260, 0, '2018-06-12 19:38:31'),
(12, 1, 6, 11, 0, 0, 160, 160, 0, '2018-06-12 19:42:14'),
(13, 1, 12, 12, 0, 0, 325, 325, 0, '2018-06-13 17:00:38'),
(14, 1, 16, 13, 0, 0, 105, 105, 0, '2018-06-13 17:06:00'),
(15, 1, 1, 14, 0, 0, 240, 240, 0, '2018-06-13 17:07:31'),
(16, 1, 11, 15, 0, 0, 220, 220, 0, '2018-06-16 18:26:44'),
(17, 1, 13, 16, 0, 0, 295, 295, 0, '2018-06-16 18:29:35'),
(18, 1, 16, 17, 0, 0, 260, 260, 0, '2018-06-16 18:31:13'),
(19, 1, 10, 18, 0, 0, 1450, 1450, 0, '2018-06-16 18:34:37'),
(20, 1, 1, 19, 0, 0, 395, 395, 0, '2018-06-16 18:43:31'),
(21, 1, 9, 20, 3, 0, 0, 0, 0, '2018-06-16 18:46:29'),
(22, 1, 12, 21, 0, 0, 375, 375, 0, '2018-06-16 18:47:31'),
(23, 1, 16, 22, 0, 0, 465, 465, 0, '2018-06-16 18:49:52'),
(24, 1, 3, 23, 0, 0, 555, 0, 555, '2018-06-16 18:52:39'),
(25, 1, 5, 24, 0, 0, 350, 350, 0, '2018-06-16 18:57:07'),
(26, 1, 3, 25, 0, 0, 790, 0, 790, '2018-06-16 19:00:13'),
(27, 1, 14, 26, 0, 0, 400, 0, 400, '2018-06-16 19:05:03'),
(28, 1, 12, 27, 0, 0, 985, 985, 0, '2018-06-16 19:17:41'),
(35, 1, 6, 32, 3, 0, 0, 0, 0, '2018-06-18 15:47:43'),
(36, 1, 10, 33, 0, 0, 35, 35, 0, '2018-06-19 19:41:01'),
(37, 1, 5, 34, 0, 0, 115, 115, 0, '2018-06-19 19:43:02'),
(38, 1, 11, 35, 0, 0, 230, 230, 0, '2018-06-19 19:46:13'),
(39, 2, 11, 35, 0, 0, 40, 40, 0, '2018-06-19 19:48:06'),
(40, 1, 14, 36, 0, 0, 190, 190, 0, '2018-06-19 19:51:13'),
(41, 1, 16, 37, 0, 0, 160, 160, 0, '2018-06-19 19:54:20'),
(42, 1, 16, 38, 0, 0, 125, 125, 0, '2018-06-19 20:00:30'),
(43, 1, 1, 39, 0, 0, 240, 0, 240, '2018-06-19 20:02:59'),
(44, 1, 5, 40, 0, 0, 295, 295, 0, '2018-06-19 20:04:40'),
(45, 1, 6, 41, 0, 0, 20, 20, 0, '2018-06-19 20:12:02'),
(46, 1, 8, 42, 0, 0, 190, 190, 0, '2018-06-23 18:39:13'),
(47, 1, 9, 43, 0, 0, 190, 190, 0, '2018-06-23 18:41:32'),
(48, 1, 14, 44, 0, 0, 195, 195, 0, '2018-06-23 18:43:05'),
(49, 1, 11, 45, 0, 0, 215, 215, 0, '2018-06-23 18:45:43'),
(50, 1, 17, 46, 0, 0, 345, 0, 345, '2018-06-23 18:48:15'),
(51, 1, 16, 47, 0, 0, 396, 396, 0, '2018-06-23 18:51:02'),
(52, 1, 1, 48, 0, 0, 600, 600, 0, '2018-06-23 18:53:04'),
(53, 1, 5, 49, 0, 0, 470, 470, 0, '2018-06-23 18:56:18'),
(54, 1, 12, 50, 0, 0, 545, 545, 0, '2018-06-23 18:59:41'),
(55, 1, 1, 51, 0, 0, 485, 0, 485, '2018-06-23 19:09:00'),
(56, 1, 3, 52, 0, 0, 530, 0, 530, '2018-06-23 19:13:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id_descuento` int(11) NOT NULL,
  `monto` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id_descuento`, `monto`) VALUES
(1, 0),
(2, 5),
(3, 10),
(4, 15),
(5, 20),
(6, 25),
(7, 30),
(8, 35),
(9, 40),
(10, 45),
(11, 50),
(12, 55),
(13, 60),
(14, 65),
(15, 70),
(16, 75),
(17, 80),
(18, 85),
(19, 90),
(20, 95),
(21, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ap` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `am` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `ap`, `am`, `telefono`) VALUES
(1, 'Mesero Generico', 'Mesero Generico', 'Mesero Generico', '1234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id_entrada` int(11) NOT NULL,
  `id_ingrediente` int(11) DEFAULT NULL,
  `cantidad_e` float DEFAULT NULL,
  `fecha_e` date DEFAULT NULL,
  `fecha_c` date DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id_entrada`, `id_ingrediente`, `cantidad_e`, `fecha_e`, `fecha_c`, `id_proveedor`, `estado`) VALUES
(1, 11, 10000, '2018-06-11', '2018-06-18', 1, 2),
(2, 19, 10000, '2018-06-11', '2018-06-18', 1, 2),
(3, 2, 48, '2018-06-11', '2018-08-10', 1, 2),
(4, 8, 36, '2018-06-11', '2018-06-11', 1, 2),
(5, 4, 36, '2018-06-11', '2018-08-10', 1, 2),
(6, 29, 950, '2018-06-25', '2021-12-31', 1, 1),
(7, 19, 10000, '2018-06-25', '2018-06-25', 1, 2),
(8, 11, 10000, '2018-06-25', '2018-06-25', 1, 1),
(9, 2, 48, '2018-06-18', '2018-06-25', 1, 1),
(10, 4, 36, '2018-06-18', '2018-06-25', 1, 1),
(11, 5, 36, '2018-06-18', '2018-06-25', 1, 1),
(12, 9, 36, '2018-06-18', '2018-06-25', 1, 1),
(13, 6, 36, '2018-06-18', '2018-06-25', 1, 1),
(14, 12, 46, '2018-06-18', '2019-06-30', 1, 1),
(15, 10, 46, '2018-06-18', '2019-06-18', 1, 2),
(16, 34, 950, '2018-06-18', '2020-06-30', 1, 1),
(17, 54, 750, '2018-06-18', '2020-06-30', 1, 1),
(18, 36, 950, '2018-06-18', '2019-06-30', 1, 1),
(19, 56, 950, '2018-06-18', '2019-06-30', 1, 1),
(20, 23, 950, '2018-06-18', '2019-06-30', 1, 1),
(21, 31, 950, '2018-06-18', '2019-06-30', 1, 1),
(22, 33, 950, '2018-06-18', '2019-06-30', 1, 1),
(23, 24, 750, '2018-06-18', '2019-06-30', 1, 1),
(24, 50, 750, '2018-06-18', '2020-06-30', 1, 1),
(25, 69, 950, '2018-06-18', '2019-06-30', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id_ingrediente` int(11) NOT NULL,
  `Descripcion` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fecha_c` date DEFAULT NULL,
  `estado_c` int(11) DEFAULT NULL,
  `id_medida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `Descripcion`, `cantidad`, `estado`, `fecha_c`, `estado_c`, `id_medida`) VALUES
(1, 'Ninguno', 0, 1, '9999-12-12', 1, 2),
(2, 'Coca Cola', 96, 1, '2018-06-25', 1, 2),
(3, 'Coca Cola Ligth', 0, 1, '2018-05-31', 1, 2),
(4, 'Fresca', 72, 1, '2018-06-25', 1, 2),
(5, 'Sprite', 36, 1, '2018-06-25', 1, 2),
(6, 'Sprite Cero', 36, 1, '2018-06-25', 1, 2),
(7, 'Sidral', 0, 1, '2018-05-31', 1, 2),
(8, 'Fanta', 36, 1, '2018-06-11', 1, 2),
(9, 'Delaware', 36, 1, '2018-06-25', 1, 2),
(10, 'Botella de Agua', 46, 1, '2019-06-18', 1, 2),
(11, 'Papas', 20000, 1, '2018-06-25', 1, 2),
(12, 'Cerveza Corona', 46, 1, '2019-06-30', 1, 2),
(13, 'Cerveza Victoria', 0, 1, '2018-05-31', 1, 2),
(14, 'Cerveza Pacifico', 0, 1, '2018-05-31', 1, 2),
(15, 'Cerveza Leon', 0, 1, '2018-05-31', 1, 2),
(16, 'Cerveza Modelo Especial', 0, 1, '2018-05-31', 1, 2),
(17, 'Cerveza Negra Modelo', 0, 1, '2018-05-31', 1, 2),
(18, 'Cerveza Corona Ligth', 0, 1, '2018-05-31', 1, 2),
(19, 'Alitas', 20000, 1, '2018-06-25', 1, 1),
(20, 'Centenario Plata', 0, 1, '2018-05-31', 1, 3),
(21, 'Centenario Reposado', 0, 1, '2018-05-31', 1, 3),
(22, 'Don Julio', 0, 1, '2018-05-31', 1, 3),
(23, 'Don Julio 70', 950, 1, '2019-06-30', 1, 3),
(24, 'Herradura Blanco', 750, 1, '2019-06-30', 1, 3),
(25, 'Herradura Plata', 0, 1, '2018-05-31', 1, 3),
(26, 'Herradura Reposado', 0, 1, '2018-05-31', 1, 3),
(27, 'Jose Cuervo', 0, 1, '2018-05-31', 1, 3),
(28, 'Tradicional', 0, 1, '2018-05-31', 1, 3),
(29, '1800', 950, 1, '2021-12-31', 1, 3),
(30, '800 Reposado', 0, 1, '2018-05-31', 1, 3),
(31, 'Buchanans', 950, 1, '2019-06-30', 1, 3),
(32, 'Jack Daniels', 0, 1, '2018-05-31', 1, 3),
(33, 'JB', 950, 1, '2019-06-30', 1, 3),
(34, 'Absolut Azul', 950, 1, '2020-06-30', 1, 3),
(35, 'Stolichnaya', 0, 1, '2018-05-31', 1, 3),
(36, 'Appleton Blanco', 950, 1, '2019-06-30', 1, 3),
(37, 'Appleton Especial', 0, 1, '2018-05-31', 1, 3),
(38, 'Bacardi Añejo', 0, 1, '2018-05-31', 1, 3),
(39, 'Bacardi Blanco', 0, 1, '2018-05-31', 1, 3),
(40, 'Bacardi Limon', 0, 1, '2018-05-31', 1, 3),
(41, 'Bacardi Razz', 0, 1, '2018-05-31', 1, 3),
(42, 'Flor de Caña', 0, 1, '2018-05-31', 1, 3),
(43, 'Havana Club', 0, 1, '2018-05-31', 1, 3),
(44, 'Malibu', 0, 1, '2018-05-31', 1, 3),
(45, 'Matesalem Platino', 0, 1, '2018-05-31', 1, 3),
(46, 'Azteca de Oro', 0, 1, '2018-05-31', 1, 3),
(47, 'Don pedro', 0, 1, '2018-05-31', 1, 3),
(48, 'Fundador', 0, 1, '2018-05-31', 1, 3),
(49, 'Terry', 0, 1, '2018-05-31', 1, 3),
(50, 'Torres 10', 750, 1, '2020-06-30', 1, 3),
(51, 'Hennessy V.S.O.P', 0, 1, '2018-05-31', 1, 3),
(52, 'Beefeater', 0, 1, '2018-05-31', 1, 3),
(53, 'Larios', 0, 1, '2018-05-31', 1, 3),
(54, 'Agavero', 750, 1, '2020-06-30', 1, 3),
(55, 'Amaretto Disarono', 0, 1, '2018-05-31', 1, 3),
(56, 'Anis Chinchon Dulce', 950, 1, '2019-06-30', 1, 3),
(57, 'Anis Chinchon Seco', 0, 1, '2018-05-31', 1, 3),
(58, 'Baileys', 0, 1, '2018-05-31', 1, 3),
(59, 'Licor de Pacharan', 0, 1, '2018-05-31', 1, 3),
(60, 'Campari', 0, 1, '2018-05-31', 1, 3),
(61, 'Dubo nnet', 0, 1, '2018-05-31', 1, 3),
(62, 'Frangelico', 0, 1, '2018-05-31', 1, 3),
(63, 'Jagermaister', 0, 1, '2018-05-31', 1, 3),
(64, 'Kahlua', 0, 1, '2018-05-31', 1, 3),
(65, 'Licor 43', 0, 1, '2018-05-31', 1, 3),
(66, 'Midori', 0, 1, '2018-05-31', 1, 3),
(67, 'Sambuca Negro', 0, 1, '2018-05-31', 1, 3),
(68, 'Vermounth Rojo', 0, 1, '2018-05-31', 1, 3),
(69, 'Vino', 950, 1, '2019-06-30', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locaciones`
--

CREATE TABLE `locaciones` (
  `id_locacion` int(11) NOT NULL,
  `numero` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_tipo_l` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `locaciones`
--

INSERT INTO `locaciones` (`id_locacion`, `numero`, `id_tipo_l`, `id_ticket`, `estado`) VALUES
(1, '2', 2, 0, 1),
(2, '2', 0, 0, 1),
(3, '3', 2, 0, 1),
(4, '4', 0, 0, 1),
(5, '4', 2, 0, 1),
(6, '1', 1, 0, 1),
(7, '2', 1, 0, 1),
(8, '3', 1, 0, 1),
(9, '4', 1, 0, 1),
(10, '5', 1, 0, 1),
(11, '5', 2, 0, 1),
(12, '6', 2, 0, 1),
(13, '7', 2, 0, 1),
(14, '8', 2, 0, 1),
(15, '9', 2, 0, 1),
(16, '1', 3, 0, 1),
(17, '2', 3, 0, 1),
(18, '3', 3, 0, 1),
(19, '4', 3, 0, 1),
(20, '5', 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida`
--

CREATE TABLE `medida` (
  `id_medida` int(11) NOT NULL,
  `descripcion` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medida`
--

INSERT INTO `medida` (`id_medida`, `descripcion`) VALUES
(1, 'Kilogramos'),
(3, 'Minilitros'),
(2, 'Unidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_de_p`
--

CREATE TABLE `metodos_de_p` (
  `id_mp` int(11) NOT NULL,
  `descripcion` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `metodos_de_p`
--

INSERT INTO `metodos_de_p` (`id_mp`, `descripcion`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta de credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_p`
--

CREATE TABLE `metodos_p` (
  `id_metodo_p` int(11) NOT NULL,
  `id_mp` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_cuenta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `metodos_p`
--

INSERT INTO `metodos_p` (`id_metodo_p`, `id_mp`, `id_ticket`, `id_cuenta`) VALUES
(1, 2, 2, 2),
(2, 1, 1, 1),
(3, 1, 3, 3),
(4, 1, 5, 6),
(5, 2, 6, 7),
(6, 1, 7, 8),
(7, 1, 7, 8),
(8, 1, 8, 9),
(9, 1, 9, 10),
(10, 1, 10, 11),
(11, 1, 11, 12),
(12, 1, 12, 13),
(13, 1, 13, 14),
(14, 1, 14, 15),
(15, 1, 15, 16),
(16, 1, 16, 17),
(17, 1, 17, 18),
(18, 1, 18, 19),
(19, 1, 19, 20),
(20, 1, 21, 22),
(21, 1, 22, 23),
(22, 2, 23, 24),
(23, 1, 24, 25),
(24, 2, 25, 26),
(25, 2, 26, 27),
(26, 2, 26, 27),
(27, 1, 27, 28),
(28, 1, 33, 36),
(29, 1, 34, 37),
(30, 1, 35, 38),
(31, 1, 35, 39),
(32, 1, 36, 40),
(33, 1, 37, 41),
(34, 1, 38, 42),
(35, 2, 39, 43),
(36, 1, 40, 44),
(37, 1, 41, 45),
(38, 1, 42, 46),
(39, 1, 43, 47),
(40, 2, 46, 50),
(41, 1, 48, 52),
(42, 2, 51, 55),
(43, 2, 52, 56),
(44, 1, 49, 53),
(45, 1, 45, 49),
(46, 1, 50, 54),
(47, 1, 44, 48),
(48, 1, 47, 51);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `descripcion`, `telefono`, `contacto`, `estado`) VALUES
(1, 'Generico', '', 'Dueña del establecimiento', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id_role`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `total` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_descuento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `total`, `subtotal`, `fecha`, `id_empleado`, `estado`, `id_descuento`) VALUES
(1, 185, 0, '2018-06-11 17:45:15', 1, 0, 0),
(2, 470, 0, '2018-06-11 18:12:35', 1, 0, 0),
(3, 225, 0, '2018-06-11 18:24:40', 1, 0, 0),
(4, 0, 0, '2018-06-11 19:09:16', 0, 3, 0),
(5, 285, 0, '2018-06-12 14:27:20', 1, 0, 0),
(6, 265, 0, '2018-06-12 17:29:45', 1, 0, 0),
(7, 335, 0, '2018-06-12 17:35:56', 1, 0, 0),
(8, 210, 0, '2018-06-12 17:40:49', 1, 0, 0),
(9, 300, 0, '2018-06-12 17:49:25', 1, 0, 0),
(10, 260, 0, '2018-06-12 19:38:31', 1, 0, 0),
(11, 160, 0, '2018-06-12 19:42:13', 1, 0, 0),
(12, 325, 0, '2018-06-13 17:00:38', 1, 0, 0),
(13, 105, 0, '2018-06-13 17:06:00', 1, 0, 0),
(14, 240, 0, '2018-06-13 17:07:30', 1, 0, 0),
(15, 220, 0, '2018-06-16 18:26:44', 1, 0, 0),
(16, 295, 0, '2018-06-16 18:29:35', 1, 0, 0),
(17, 260, 0, '2018-06-16 18:31:13', 1, 0, 0),
(18, 1450, 0, '2018-06-16 18:34:37', 1, 0, 0),
(19, 395, 0, '2018-06-16 18:43:31', 1, 0, 0),
(20, 0, 0, '2018-06-16 18:46:29', 0, 3, 0),
(21, 375, 0, '2018-06-16 18:47:31', 1, 0, 0),
(22, 465, 0, '2018-06-16 18:49:52', 1, 0, 0),
(23, 555, 0, '2018-06-16 18:52:39', 1, 0, 0),
(24, 350, 0, '2018-06-16 18:57:07', 1, 0, 0),
(25, 790, 0, '2018-06-16 19:00:13', 1, 0, 0),
(26, 400, 0, '2018-06-16 19:05:02', 1, 0, 0),
(27, 985, 0, '2018-06-16 19:17:41', 1, 0, 0),
(32, 0, 0, '2018-06-18 15:47:43', 0, 3, 0),
(33, 35, 0, '2018-06-19 19:41:01', 1, 0, 0),
(34, 115, 0, '2018-06-19 19:43:02', 1, 0, 0),
(35, 270, 0, '2018-06-19 19:46:13', 1, 0, 0),
(36, 190, 0, '2018-06-19 19:51:13', 1, 0, 0),
(37, 160, 0, '2018-06-19 19:54:20', 1, 0, 0),
(38, 125, 0, '2018-06-19 20:00:30', 1, 0, 0),
(39, 240, 0, '2018-06-19 20:02:58', 1, 0, 0),
(40, 295, 0, '2018-06-19 20:04:40', 1, 0, 0),
(41, 20, 0, '2018-06-19 20:12:02', 1, 0, 0),
(42, 190, 0, '2018-06-23 18:39:12', 1, 0, 0),
(43, 190, 0, '2018-06-23 18:41:32', 1, 0, 0),
(44, 195, 0, '2018-06-23 18:43:04', 1, 0, 0),
(45, 215, 0, '2018-06-23 18:45:43', 1, 0, 0),
(46, 345, 0, '2018-06-23 18:48:15', 1, 0, 0),
(47, 396, 0, '2018-06-23 18:51:02', 1, 0, 0),
(48, 600, 0, '2018-06-23 18:53:04', 1, 0, 0),
(49, 470, 0, '2018-06-23 18:56:18', 1, 0, 0),
(50, 545, 0, '2018-06-23 18:59:41', 1, 0, 0),
(51, 485, 0, '2018-06-23 19:08:59', 1, 0, 0),
(52, 530, 0, '2018-06-23 19:13:26', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_l`
--

CREATE TABLE `tipos_l` (
  `id_tipo_l` int(11) NOT NULL,
  `descripcion` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_l`
--

INSERT INTO `tipos_l` (`id_tipo_l`, `descripcion`) VALUES
(1, 'Barra'),
(2, 'Mesa'),
(3, 'Terraza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_sesiones`
--

CREATE TABLE `t_sesiones` (
  `id_sesion` int(11) NOT NULL,
  `fecha_i` datetime DEFAULT NULL,
  `estado_i` int(11) DEFAULT NULL,
  `fecha_c` datetime DEFAULT NULL,
  `estado_c` int(11) DEFAULT NULL,
  `id_usuario_i` int(11) DEFAULT NULL,
  `id_usuario_c` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `t_sesiones`
--

INSERT INTO `t_sesiones` (`id_sesion`, `fecha_i`, `estado_i`, `fecha_c`, `estado_c`, `id_usuario_i`, `id_usuario_c`) VALUES
(1, '2018-06-11 17:42:19', 2, '2018-06-12 19:44:28', 1, 2, 2),
(2, '2018-06-13 17:00:28', 2, '2018-06-13 19:53:07', 1, 2, 2),
(3, '2018-06-16 18:26:28', 2, '2018-06-19 19:40:16', 1, 2, 2),
(4, '2018-06-19 19:40:54', 2, '2018-06-19 20:13:48', 1, 2, 2),
(5, '2018-06-23 18:38:07', 2, '2018-06-23 18:38:32', 1, 2, 2),
(6, '2018-06-23 18:39:07', 2, '2018-06-23 19:20:05', 1, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contraseña` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `contraseña`, `id_role`) VALUES
(1, 'puch', 'puchito', 1),
(2, 'capi', '123456', 2),
(3, 'admincapi', 'capi', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_alimento` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `id_cuenta` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_v` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `cantidad`, `id_alimento`, `subtotal`, `id_cuenta`, `estado`, `id_usuario`, `tipo_v`) VALUES
(1, 1, 13, 130, 1, 0, 2, 1),
(2, 1, 10, 110, 2, 0, 2, 1),
(3, 1, 18, 165, 2, 0, 2, 1),
(4, 1, 25, 45, 2, 0, 2, 1),
(5, 1, 24, 45, 2, 0, 2, 1),
(6, 1, 18, 165, 3, 0, 2, 1),
(7, 1, 13, 130, 6, 0, 2, 1),
(8, 1, 14, 130, 6, 0, 2, 1),
(9, 1, 6, 75, 8, 0, 2, 1),
(10, 1, 13, 130, 9, 0, 2, 1),
(11, 1, 10, 110, 10, 0, 2, 1),
(12, 1, 14, 130, 10, 0, 2, 1),
(13, 1, 8, 55, 11, 0, 2, 1),
(14, 2, 26, 100, 12, 0, 2, 1),
(15, 1, 2, 80, 13, 0, 2, 1),
(16, 1, 5, 75, 14, 0, 2, 1),
(17, 1, 10, 110, 15, 0, 2, 1),
(18, 1, 13, 130, 15, 0, 2, 1),
(19, 2, 6, 150, 16, 0, 2, 1),
(20, 2, 10, 220, 17, 0, 2, 1),
(21, 1, 6, 75, 17, 0, 2, 1),
(22, 1, 10, 110, 18, 0, 2, 1),
(23, 1, 14, 130, 19, 0, 2, 1),
(24, 1, 19, 160, 19, 0, 2, 1),
(25, 4, 10, 440, 19, 0, 2, 1),
(26, 1, 13, 130, 19, 0, 2, 1),
(27, 1, 2, 80, 19, 0, 2, 1),
(28, 1, 8, 55, 20, 0, 2, 1),
(29, 1, 10, 110, 20, 0, 2, 1),
(30, 1, 14, 130, 20, 0, 2, 1),
(31, 1, 2, 80, 22, 0, 2, 1),
(32, 1, 18, 165, 22, 0, 2, 1),
(33, 1, 6, 75, 23, 0, 2, 1),
(34, 1, 7, 35, 23, 0, 2, 1),
(35, 1, 5, 75, 23, 0, 2, 1),
(36, 1, 14, 130, 23, 0, 2, 1),
(37, 1, 6, 75, 24, 0, 2, 1),
(38, 1, 10, 110, 25, 0, 2, 1),
(39, 1, 18, 165, 25, 0, 2, 1),
(40, 1, 5, 75, 26, 0, 2, 1),
(41, 1, 10, 110, 26, 0, 2, 1),
(42, 1, 13, 130, 26, 0, 2, 1),
(43, 1, 18, 165, 26, 0, 2, 1),
(44, 1, 13, 130, 27, 0, 2, 1),
(45, 1, 8, 55, 28, 0, 2, 1),
(46, 1, 10, 110, 28, 0, 2, 1),
(47, 1, 13, 130, 28, 0, 2, 1),
(48, 1, 21, 175, 28, 0, 2, 1),
(49, 0, 5, 0, 29, 2, 2, 1),
(50, 0, 9, 0, 29, 2, 2, 1),
(51, 0, 11, 0, 30, 2, 2, 1),
(52, 1, 27, 30, 37, 0, 2, 1),
(53, 1, 14, 130, 38, 0, 2, 1),
(54, 1, 9, 65, 38, 0, 2, 1),
(55, 1, 7, 35, 38, 0, 2, 1),
(56, 2, 27, 60, 41, 0, 2, 1),
(57, 1, 8, 55, 42, 0, 2, 1),
(58, 1, 18, 165, 43, 0, 2, 1),
(59, 1, 8, 55, 43, 0, 2, 1),
(60, 1, 18, 165, 44, 0, 2, 1),
(61, 2, 9, 130, 46, 0, 2, 1),
(62, 1, 13, 130, 47, 0, 2, 1),
(63, 1, 18, 165, 49, 0, 2, 1),
(64, 1, 14, 130, 51, 0, 2, 1),
(65, 1, 17, 160, 51, 0, 2, 1),
(66, 1, 11, 220, 52, 0, 2, 1),
(67, 1, 14, 130, 53, 0, 2, 1),
(68, 0, 11, 0, 53, 2, 2, 1),
(69, 2, 27, 60, 53, 0, 2, 1),
(70, 1, 10, 110, 53, 0, 2, 1),
(71, 1, 5, 75, 54, 0, 2, 1),
(72, 2, 2, 160, 54, 0, 2, 1),
(73, 1, 8, 55, 55, 0, 2, 1),
(74, 1, 18, 165, 55, 0, 2, 1),
(75, 1, 21, 175, 55, 0, 2, 1),
(76, 1, 2, 80, 56, 0, 2, 1),
(77, 0, 11, 0, 56, 2, 2, 1),
(78, 1, 10, 110, 56, 0, 2, 1),
(79, 1, 17, 160, 56, 0, 2, 1);

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `Bv` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN 				
		if new.estado = 2 then                
		INSERT INTO BventasC values (null,new.id_venta,new.id_cuenta,old.cantidad,new.id_alimento,old.subtotal,now(),new.id_usuario);                
		else					
			if new.estado =1 then					
			INSERT INTO Bventas values(null,new.id_venta,new.id_cuenta,new.cantidad,old.cantidad,new.id_alimento,new.subtotal,old.subtotal,now(),new.id_usuario);
                    	end if;                
		end if;	
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventasb`
--

CREATE TABLE `ventasb` (
  `id_ventaB` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_bebida` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `id_cuenta` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_v` int(11) DEFAULT NULL,
  `id_ingrediente_s` int(11) DEFAULT NULL,
  `cantidad_s` float DEFAULT NULL,
  `id_ingrediente_ss` int(11) DEFAULT NULL,
  `cantidad_ss` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventasb`
--

INSERT INTO `ventasb` (`id_ventaB`, `cantidad`, `id_bebida`, `subtotal`, `id_cuenta`, `estado`, `id_usuario`, `tipo_v`, `id_ingrediente_s`, `cantidad_s`, `id_ingrediente_ss`, `cantidad_ss`) VALUES
(1, 1, 25, 20, 1, 0, 2, 3, 1, 0, 1, 0),
(2, 1, 37, 35, 2, 0, 2, 3, 1, 0, 1, 0),
(3, 1, 11, 30, 2, 0, 2, 3, 1, 0, 1, 0),
(4, 1, 19, 40, 2, 0, 2, 3, 1, 0, 1, 0),
(5, 1, 34, 35, 1, 0, 2, 3, 1, 0, 1, 0),
(6, 1, 22, 20, 3, 0, 2, 3, 1, 0, 1, 0),
(7, 0, 37, 0, 3, 2, 2, 3, 1, 0, 1, 0),
(8, 1, 103, 40, 3, 0, 2, 3, 1, 0, 1, 0),
(9, 3, 32, 90, 7, 0, 2, 3, 1, 0, 1, 0),
(10, 3, 35, 90, 8, 0, 2, 3, 1, 0, 1, 0),
(11, 0, 35, 0, 9, 2, 2, 3, 1, 0, 1, 0),
(12, 2, 35, 60, 9, 0, 2, 3, 1, 0, 1, 0),
(13, 1, 22, 20, 9, 0, 2, 3, 1, 0, 1, 0),
(14, 2, 35, 60, 10, 0, 2, 3, 1, 0, 1, 0),
(15, 1, 29, 20, 11, 0, 2, 3, 1, 0, 1, 0),
(16, 1, 22, 20, 11, 0, 2, 3, 1, 0, 1, 0),
(17, 2, 32, 60, 12, 0, 2, 3, 1, 0, 1, 0),
(18, 0, 37, 0, 13, 2, 2, 3, 1, 0, 1, 0),
(19, 1, 37, 35, 13, 0, 2, 3, 1, 0, 1, 0),
(20, 1, 36, 40, 13, 0, 2, 3, 1, 0, 1, 0),
(21, 1, 32, 30, 14, 0, 2, 3, 1, 0, 1, 0),
(22, 1, 35, 30, 16, 0, 2, 3, 1, 0, 1, 0),
(23, 2, 35, 60, 18, 0, 2, 3, 1, 0, 1, 0),
(24, 2, 35, 60, 20, 0, 2, 3, 1, 0, 1, 0),
(25, 2, 22, 40, 20, 0, 2, 3, 1, 0, 1, 0),
(26, 2, 35, 60, 22, 0, 2, 3, 1, 0, 1, 0),
(27, 2, 34, 70, 22, 0, 2, 3, 1, 0, 1, 0),
(28, 3, 32, 90, 23, 0, 2, 3, 1, 0, 1, 0),
(29, 3, 22, 60, 23, 0, 2, 3, 1, 0, 1, 0),
(30, 3, 22, 60, 24, 0, 2, 3, 1, 0, 1, 0),
(31, 17, 22, 340, 25, 0, 2, 3, 1, 0, 1, 0),
(32, 2, 21, 100, 26, 0, 2, 3, 1, 0, 1, 0),
(33, 1, 35, 30, 26, 0, 2, 3, 1, 0, 1, 0),
(34, 3, 37, 105, 26, 0, 2, 3, 1, 0, 1, 0),
(35, 1, 51, 75, 26, 0, 2, 3, 1, 0, 1, 0),
(36, 2, 32, 60, 27, 0, 2, 3, 1, 0, 1, 0),
(37, 2, 31, 40, 27, 0, 2, 3, 1, 0, 1, 0),
(38, 3, 36, 120, 28, 0, 2, 3, 1, 0, 1, 0),
(39, 3, 10, 90, 28, 0, 2, 3, 1, 0, 1, 0),
(40, 2, 16, 70, 28, 0, 2, 3, 1, 0, 1, 0),
(41, 1, 15, 45, 28, 0, 2, 3, 1, 0, 1, 0),
(42, 1, 22, 20, 28, 0, 2, 3, 1, 0, 1, 0),
(43, 0, 32, 0, 29, 2, 2, 3, 1, 0, 1, 0),
(44, 0, 31, 0, 31, 2, 2, 3, 1, 0, 1, 0),
(45, 0, 31, 0, 32, 2, 2, 3, 1, 0, 1, 0),
(46, 0, 31, 0, 33, 2, 2, 3, 1, 0, 1, 0),
(47, 0, 31, 0, 35, 2, 2, 3, 1, 0, 1, 0),
(48, 1, 4, 35, 36, 0, 2, 3, 1, 0, 1, 0),
(49, 2, 2, 50, 37, 0, 2, 3, 1, 0, 1, 0),
(50, 1, 4, 35, 37, 0, 2, 3, 1, 0, 1, 0),
(51, 1, 29, 20, 39, 0, 2, 3, 1, 0, 1, 0),
(52, 1, 28, 20, 39, 0, 2, 3, 1, 0, 1, 0),
(53, 1, 32, 30, 40, 0, 2, 3, 1, 0, 1, 0),
(54, 1, 38, 30, 40, 0, 2, 3, 1, 0, 1, 0),
(55, 1, 3, 35, 41, 0, 2, 3, 1, 0, 1, 0),
(56, 1, 1, 25, 41, 0, 2, 3, 1, 0, 1, 0),
(57, 1, 16, 35, 42, 0, 2, 3, 1, 0, 1, 0),
(58, 1, 13, 35, 42, 0, 2, 3, 1, 0, 1, 0),
(59, 1, 22, 20, 43, 0, 2, 3, 1, 0, 1, 0),
(60, 2, 35, 60, 44, 0, 2, 3, 1, 0, 1, 0),
(61, 1, 13, 35, 44, 0, 2, 3, 1, 0, 1, 0),
(62, 1, 37, 35, 44, 0, 2, 3, 1, 0, 1, 0),
(63, 1, 31, 20, 45, 0, 2, 3, 1, 0, 1, 0),
(64, 2, 32, 60, 46, 0, 2, 3, 1, 0, 1, 0),
(65, 2, 35, 60, 47, 0, 2, 3, 1, 0, 1, 0),
(66, 1, 32, 30, 48, 0, 2, 3, 1, 0, 1, 0),
(67, 1, 10, 30, 48, 0, 2, 3, 1, 0, 1, 0),
(68, 1, 28, 20, 49, 0, 2, 3, 1, 0, 1, 0),
(69, 1, 35, 30, 49, 0, 2, 3, 1, 0, 1, 0),
(70, 2, 10, 60, 50, 0, 2, 3, 1, 0, 1, 0),
(71, 3, 13, 105, 50, 0, 2, 3, 1, 0, 1, 0),
(72, 1, 15, 45, 50, 0, 2, 3, 1, 0, 1, 0),
(73, 5, 32, 150, 51, 0, 2, 3, 1, 0, 1, 0),
(74, 3, 15, 135, 52, 0, 2, 3, 1, 0, 1, 0),
(75, 1, 20, 45, 52, 0, 2, 3, 1, 0, 1, 0),
(76, 1, 34, 35, 52, 0, 2, 3, 1, 0, 1, 0),
(77, 5, 10, 150, 53, 0, 2, 3, 1, 0, 1, 0),
(78, 1, 28, 20, 53, 0, 2, 3, 1, 0, 1, 0),
(79, 1, 13, 35, 54, 0, 2, 3, 1, 0, 1, 0),
(80, 5, 31, 100, 54, 0, 2, 3, 1, 0, 1, 0),
(81, 1, 14, 40, 54, 0, 2, 3, 1, 0, 1, 0),
(82, 1, 13, 35, 55, 0, 2, 3, 1, 0, 1, 0),
(83, 1, 22, 20, 55, 0, 2, 3, 1, 0, 1, 0),
(84, 1, 34, 35, 55, 0, 2, 3, 1, 0, 1, 0),
(85, 2, 93, 120, 56, 0, 2, 3, 1, 0, 1, 0),
(86, 2, 32, 60, 56, 0, 2, 3, 1, 0, 1, 0);

--
-- Disparadores `ventasb`
--
DELIMITER $$
CREATE TRIGGER `Bb` AFTER UPDATE ON `ventasb` FOR EACH ROW BEGIN 				
		if new.estado = 2 then                
		INSERT INTO BventasCb values (null,new.id_ventaB,new.id_cuenta,old.cantidad,new.id_bebida,old.subtotal,now(),new.id_usuario);                
		else					
			if new.estado =1 then					
			INSERT INTO Bventasb values(null,new.id_ventaB,new.id_cuenta,new.cantidad,old.cantidad,new.id_bebida,new.subtotal,old.subtotal,now(),new.id_usuario);
                    	end if;                
		end if;	
	END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id_alimento`);

--
-- Indices de la tabla `bcom`
--
ALTER TABLE `bcom`
  ADD PRIMARY KEY (`id_Bcom`);

--
-- Indices de la tabla `bcomc`
--
ALTER TABLE `bcomc`
  ADD PRIMARY KEY (`id_BcomC`);

--
-- Indices de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  ADD PRIMARY KEY (`id_bebida`);

--
-- Indices de la tabla `bitacoracor`
--
ALTER TABLE `bitacoracor`
  ADD PRIMARY KEY (`id_bitacora`);

--
-- Indices de la tabla `bitacorain`
--
ALTER TABLE `bitacorain`
  ADD PRIMARY KEY (`id_ingredienteO`);

--
-- Indices de la tabla `bventas`
--
ALTER TABLE `bventas`
  ADD PRIMARY KEY (`id_Bventa`);

--
-- Indices de la tabla `bventasb`
--
ALTER TABLE `bventasb`
  ADD PRIMARY KEY (`id_Bventab`);

--
-- Indices de la tabla `bventasc`
--
ALTER TABLE `bventasc`
  ADD PRIMARY KEY (`id_BventasC`);

--
-- Indices de la tabla `bventascb`
--
ALTER TABLE `bventascb`
  ADD PRIMARY KEY (`id_BventasC`);

--
-- Indices de la tabla `categorias_a`
--
ALTER TABLE `categorias_a`
  ADD PRIMARY KEY (`id_categoria_a`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `complementos`
--
ALTER TABLE `complementos`
  ADD PRIMARY KEY (`id_complemento`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id_cuenta`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id_descuento`),
  ADD UNIQUE KEY `monto` (`monto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_entrada`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD UNIQUE KEY `Descripcion` (`Descripcion`);

--
-- Indices de la tabla `locaciones`
--
ALTER TABLE `locaciones`
  ADD PRIMARY KEY (`id_locacion`);

--
-- Indices de la tabla `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`id_medida`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `metodos_de_p`
--
ALTER TABLE `metodos_de_p`
  ADD PRIMARY KEY (`id_mp`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `metodos_p`
--
ALTER TABLE `metodos_p`
  ADD PRIMARY KEY (`id_metodo_p`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`);

--
-- Indices de la tabla `tipos_l`
--
ALTER TABLE `tipos_l`
  ADD PRIMARY KEY (`id_tipo_l`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `t_sesiones`
--
ALTER TABLE `t_sesiones`
  ADD PRIMARY KEY (`id_sesion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- Indices de la tabla `ventasb`
--
ALTER TABLE `ventasb`
  ADD PRIMARY KEY (`id_ventaB`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id_alimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `bcom`
--
ALTER TABLE `bcom`
  MODIFY `id_Bcom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `bcomc`
--
ALTER TABLE `bcomc`
  MODIFY `id_BcomC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  MODIFY `id_bebida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `bitacoracor`
--
ALTER TABLE `bitacoracor`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacorain`
--
ALTER TABLE `bitacorain`
  MODIFY `id_ingredienteO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bventas`
--
ALTER TABLE `bventas`
  MODIFY `id_Bventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bventasb`
--
ALTER TABLE `bventasb`
  MODIFY `id_Bventab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `bventasc`
--
ALTER TABLE `bventasc`
  MODIFY `id_BventasC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `bventascb`
--
ALTER TABLE `bventascb`
  MODIFY `id_BventasC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias_a`
--
ALTER TABLE `categorias_a`
  MODIFY `id_categoria_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `complementos`
--
ALTER TABLE `complementos`
  MODIFY `id_complemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `locaciones`
--
ALTER TABLE `locaciones`
  MODIFY `id_locacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `medida`
--
ALTER TABLE `medida`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `metodos_de_p`
--
ALTER TABLE `metodos_de_p`
  MODIFY `id_mp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `metodos_p`
--
ALTER TABLE `metodos_p`
  MODIFY `id_metodo_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tipos_l`
--
ALTER TABLE `tipos_l`
  MODIFY `id_tipo_l` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `t_sesiones`
--
ALTER TABLE `t_sesiones`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `ventasb`
--
ALTER TABLE `ventasb`
  MODIFY `id_ventaB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
