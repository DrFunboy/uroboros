AFTER INSERT ON `@@@invoice` FOR EACH ROW
IF (NEW.`sum` > 0) THEN
  CALL @@@sportsmen_calc_saldo(NEW.`sportsmen`);
  CALL @@@invoicepay_recalc(NEW.`sportsmen`);
END IF