AFTER DELETE ON `@@@pay` FOR EACH ROW
BEGIN
  DELETE FROM @@@invoicepay where idpay = OLD.id;
  CALL @@@sportsmen_calc_saldo(OLD.`sportsmen`);
  CALL @@@invoicepay_recalc(OLD.`sportsmen`);
END